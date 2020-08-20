<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use Yajra\DataTables\Datatables;

use App\User;
use App\UsersDetail;
use App\Schedule;
use App\Days;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except(['login', 'getAuthenticatedUser']);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('email', request('email'))->first();

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function getSchedule() {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $now = Carbon::now();

        $getDays = Days::where('name_day', $now->format('l'))->first();

        $schedule = Schedule::where('users_id', $user->id)->where('days_id', $getDays->id)->with(['Days','Users'])->first();

        $data = (array) $schedule;
        if($data){
            return response()->json($schedule);
        } else {
            return response()->json(['msg' => 'Has no record schedule!']);
        }
    }

    public function getEmployee() {
        $userDetail = UsersDetail::all();

        return view('employee.index', ['userDetail' => $userDetail]);
    }

    public function createEmployee() {
        return view('employee.form', ['action' => 'create']);
    }

    public function postEmployee() {

        

        // return response()->json(request()->all());

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        // $user->password = Hash::make(request()->password);
        $user->password = Hash::make('12345678');

        $user->save();

        $userDetail = new UsersDetail;
        $userDetail->users_id = $user->id;
        $userDetail->full_name = request()->name;
        $userDetail->nick_name = request()->nick_name;
        $userDetail->birth_city = request()->birth_city;

        if(request()->hasFile('foto')){
            $file = request()->file('foto');
     
            $nama_file = $user->id.'.'.$file->getClientOriginalExtension();
     
            $tujuan_upload = 'foto/employee';
            $file->move($tujuan_upload,$nama_file);
            $userDetail->foto = $nama_file;
        }

        // $birthDate = Carbon::parse(request()->birth_date);

        // $userDetail->birth_date = $birthDate->format('YYYY-MM-DD');
        $userDetail->birth_date = request()->birth_date;
        $userDetail->address = request()->address;
        $userDetail->address_city = request()->address_city;
        $userDetail->address_postal_code = request()->address_postal_code;
        $userDetail->phone_office = request()->phone_office;
        $userDetail->phone_mobile = request()->phone_mobile;
        $userDetail->phone_home = request()->phone_home;
        $userDetail->religion = request()->religion;
        $userDetail->card_identity_number = substr(request()->card_identity_number, 0, 16);
        $userDetail->number_of_siblings = request()->number_of_siblings;
        $userDetail->status = request()->status;
        $userDetail->nama_istri_suami = request()->nama_istri_suami;
        $userDetail->pekerjaan_istri_suami = request()->pekerjaan_istri_suami;
        $userDetail->jumlah_anak = request()->jumlah_anak;

        $allAnak = [];

        if(request()->jumlah_anak != 0) {
            for($i=0;$i < count(request()->anak);){
                array_push($allAnak, json_encode([
                    'nama' => request()->anak[$i++],
                    'jenis_kelamin' => request()->anak[$i++],
                    'tgl_lahir' => request()->anak[$i++],
                    'pendidikan_pekerjaan' => request()->anak[$i++],
                ]));
            }
        }

        $userDetail->anak = request()->jumlah_anak != 0 ? json_encode($allAnak) : null;
        $userDetail->nama_darurat = request()->nama_darurat;
        $userDetail->address_darurat = request()->address_darurat;
        $userDetail->tlp_darurat = request()->tlp_darurat;
        $userDetail->nama_ayah = request()->nama_ayah;
        $userDetail->pekerjaan_ayah = request()->pekerjaan_ayah;
        $userDetail->alamat_ayah = request()->alamat_ayah;
        $userDetail->nama_ibu = request()->nama_ibu;
        $userDetail->pekerjaan_ibu = request()->pekerjaan_ibu;
        $userDetail->alamat_ibu = request()->alamat_ibu;

        $allPendFormal = [];
        $mergePendFormal = array_merge(request()->pendNormalSd,
        request()->pendNormalSmp,
        request()->pendNormalSlta,
        request()->pendNormalAkadUniv,
        request()->pendNormalUniv);

        for($i=0;$i < count($mergePendFormal);){
            array_push($allPendFormal, json_encode([
                'nama_sekolah' => $mergePendFormal[$i++],
                'tempat' => $mergePendFormal[$i++],
                'tahun_lulus' => $mergePendFormal[$i++],
            ]));
        }

        $userDetail->pendidikan_formal = json_encode($allPendFormal);

        if(request()->nonformal[0] != null){
            $allPendNonFormal = [];
            for($i=0;$i < count(request()->nonformal);){
                array_push($allPendNonFormal, json_encode([
                    'macam' => request()->nonformal[$i++],
                    'instansi' => request()->nonformal[$i++],
                    'tempat' => request()->nonformal[$i++],
                    'tahun' => request()->nonformal[$i++],
                ]));
            }
    
            $userDetail->pendidikan_nonformal = json_encode($allPendNonFormal);
        }

        if(request()->organisasi[0] != null){
            $allOrganisasi = [];
            for($i=0;$i < count(request()->organisasi);){
                array_push($allOrganisasi, json_encode([
                    'nama_organisasi' => request()->organisasi[$i++],
                    'jabatan' => request()->organisasi[$i++],
                    'tahun' => request()->organisasi[$i++],
                    'tempat' => request()->organisasi[$i++],
                ]));
            }

            $userDetail->kehidupan_berorganisasi = json_encode($allOrganisasi);
        }

        if(request()->pengalamanKerja[0] != null){
            $allpengalamanKerja = [];
            for($i=0;$i < count(request()->pengalamanKerja);){
                array_push($allpengalamanKerja, json_encode([
                    'nama_perusahaan' => request()->pengalamanKerja[$i++],
                    'jabatan' => request()->pengalamanKerja[$i++],
                    'tahun_awal' => request()->pengalamanKerja[$i++],
                    'tahun_akhir' => request()->pengalamanKerja[$i++],
                    'alasan' => request()->pengalamanKerja[$i++],
                ]));
            }

            $userDetail->pengalaman_bekerja = json_encode($allpengalamanKerja);
        }

        if(request()->pengalamanKerja[0] != null){
            $allpengalamanMengajar = [];
            for($i=0;$i < count(request()->pengalamanMengajar);){
                array_push($allpengalamanMengajar, json_encode([
                    'nama_lembaga' => request()->pengalamanMengajar[$i++],
                    'materi' => request()->pengalamanMengajar[$i++],
                    'tahun_awal' => request()->pengalamanMengajar[$i++],
                    'tahun_akhir' => request()->pengalamanMengajar[$i++],
                    'alasan' => request()->pengalamanMengajar[$i++],
                ]));
            }
            $userDetail->pengalaman_mengajar = json_encode($allpengalamanMengajar);
        }


        $userDetail->kk_mengajar_matkul = request()->kk_mengajar_matkul;
        $userDetail->kk_software_dikuasai = request()->kk_software_dikuasai;
        $userDetail->kk_bahasa_pemograman = request()->kk_bahasa_pemograman;
        $userDetail->kk_hardware_dikuasai = request()->kk_hardware_dikuasai;
        $userDetail->kk_menguasai_jaringan = request()->kk_menguasai_jaringan;
        $userDetail->kk_jaringan_dikuasai = request()->kk_jaringan_dikuasai;
        $userDetail->kk_sofware_pernah_dibuat = request()->kk_sofware_pernah_dibuat;
        $userDetail->kk_sofware_pernah_dibuat_detail = request()->kk_sofware_pernah_dibuat_detail;
        $userDetail->kk_sofware_pernah_dibuat_bahasa_pemograman = request()->kk_sofware_pernah_dibuat_bahasa_pemograman;
        $userDetail->kk_mengarang_buku = request()->kk_mengarang_buku;
        $userDetail->kk_mengarang_buku_judul = request()->kk_mengarang_buku_judul;
        $userDetail->kk_mengarang_buku_penerbit = request()->kk_mengarang_buku_penerbit;
        $userDetail->kk_mengarang_buku_tahun_penerbit = request()->kk_mengarang_buku_tahun_penerbit;
        $userDetail->kk_keahlian_diluar_komputer = request()->kk_keahlian_diluar_komputer;
        $userDetail->olah_raga = request()->olah_raga;
        $userDetail->macam_olahraga = request()->macam_olahraga;
        $userDetail->sakit_berat = request()->sakit_berat;
        $userDetail->macam_sakit_berat = request()->macam_sakit_berat;
        $userDetail->kecelakaan_berat = request()->kecelakaan_berat;
        $userDetail->jenis_kecelakaan = request()->jenis_kecelakaan;
        $userDetail->bila_mana_kecelakaan = request()->bila_mana_kecelakaan;
        $userDetail->akibat_kecelakaan = request()->akibat_kecelakaan;

        $userDetail->save();

        if($userDetail){
            return view('employee.index')->with('success','Data berhasil disimpan!');
        }

        return view('employee.form')->with('danger','Terjadi masalah!');
    }

    public function getDetailEmployee($id) {
        $user = User::find($id);
        $userDetail = UsersDetail::where('users_id',$user->id)->first();

        $userDetail->anak = json_decode($userDetail->anak);
        $userDetail->pendidikan_formal = json_decode($userDetail->pendidikan_formal);
        $userDetail->pendidikan_nonformal = json_decode($userDetail->pendidikan_nonformal);
        $userDetail->kehidupan_berorganisasi = json_decode($userDetail->kehidupan_berorganisasi);
        $userDetail->pengalaman_bekerja = json_decode($userDetail->pengalaman_bekerja);
        $userDetail->pengalaman_mengajar = json_decode($userDetail->pengalaman_mengajar);

        if($userDetail){
            return view('employee.form', ['user' => $user, 'userDetail' => $userDetail, 'action' => 'edit']);
        }
        return view('employee.index')->with('danger','User tidak ditemukan');
    }

    public function updateEmployee($id) {
        $user = User::find($id);
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = request()->password != '' ? Hash::make(request()->password) : $user->password;

        $user->save();

        // return response()->json($user->id);

        $userDetail = UsersDetail::where('users_id', $id)->first();
        $userDetail->users_id = $user->id;
        $userDetail->full_name = request()->name;
        $userDetail->nick_name = request()->nick_name;
        $userDetail->birth_city = request()->birth_city;

        if(request()->hasFile('foto')){
            $file = request()->file('foto');
     
            $nama_file = $user->id.'.'.$file->getClientOriginalExtension();
     
            $tujuan_upload = 'foto/employee';
            $file->move($tujuan_upload,$nama_file);
            $userDetail->foto = $nama_file;
        }

        // $birthDate = Carbon::parse(request()->birth_date);

        // $userDetail->birth_date = $birthDate->format('YYYY-MM-DD');
        $userDetail->birth_date = request()->birth_date;
        $userDetail->address = request()->address;
        $userDetail->address_city = request()->address_city;
        $userDetail->address_postal_code = request()->address_postal_code;
        $userDetail->phone_office = request()->phone_office;
        $userDetail->phone_mobile = request()->phone_mobile;
        $userDetail->phone_home = request()->phone_home;
        $userDetail->religion = request()->religion;
        $userDetail->card_identity_number = substr(request()->card_identity_number, 0, 16);
        $userDetail->number_of_siblings = request()->number_of_siblings;
        $userDetail->status = request()->status;
        $userDetail->nama_istri_suami = request()->nama_istri_suami;
        $userDetail->pekerjaan_istri_suami = request()->pekerjaan_istri_suami;
        $userDetail->jumlah_anak = request()->jumlah_anak;

        $allAnak = [];
        if(request()->jumlah_anak != 0) {
            for($i=0;$i < count(request()->anak);){
                array_push($allAnak, json_encode([
                    'nama' => request()->anak[$i++],
                    'jenis_kelamin' => request()->anak[$i++],
                    'tgl_lahir' => request()->anak[$i++],
                    'pendidikan_pekerjaan' => request()->anak[$i++],
                ]));
            }
        }

        $userDetail->anak = request()->jumlah_anak != 0 ? json_encode($allAnak) : null;
        $userDetail->nama_darurat = request()->nama_darurat;
        $userDetail->address_darurat = request()->address_darurat;
        $userDetail->tlp_darurat = request()->tlp_darurat;
        $userDetail->nama_ayah = request()->nama_ayah;
        $userDetail->pekerjaan_ayah = request()->pekerjaan_ayah;
        $userDetail->alamat_ayah = request()->alamat_ayah;
        $userDetail->nama_ibu = request()->nama_ibu;
        $userDetail->pekerjaan_ibu = request()->pekerjaan_ibu;
        $userDetail->alamat_ibu = request()->alamat_ibu;

        $allPendFormal = [];
        $mergePendFormal = array_merge(request()->pendNormalSd,
        request()->pendNormalSmp,
        request()->pendNormalSlta,
        request()->pendNormalAkadUniv,
        request()->pendNormalUniv);

        for($i=0;$i < count($mergePendFormal);){
            array_push($allPendFormal, json_encode([
                'nama_sekolah' => $mergePendFormal[$i++],
                'tempat' => $mergePendFormal[$i++],
                'tahun_lulus' => $mergePendFormal[$i++],
            ]));
        }

        $userDetail->pendidikan_formal = json_encode($allPendFormal);

        if(request()->nonformal[0] != null){
            $allPendNonFormal = [];
            for($i=0;$i < count(request()->nonformal);){
                array_push($allPendNonFormal, json_encode([
                    'macam' => request()->nonformal[$i++],
                    'instansi' => request()->nonformal[$i++],
                    'tempat' => request()->nonformal[$i++],
                    'tahun' => request()->nonformal[$i++],
                ]));
            }
    
            $userDetail->pendidikan_nonformal = json_encode($allPendNonFormal);
        }

        if(request()->organisasi[0] != null){
            $allOrganisasi = [];
            for($i=0;$i < count(request()->organisasi);){
                array_push($allOrganisasi, json_encode([
                    'nama_organisasi' => request()->organisasi[$i++],
                    'jabatan' => request()->organisasi[$i++],
                    'tahun' => request()->organisasi[$i++],
                    'tempat' => request()->organisasi[$i++],
                ]));
            }

            $userDetail->kehidupan_berorganisasi = json_encode($allOrganisasi);
        }

        if(request()->pengalamanKerja[0] != null){
            $allpengalamanKerja = [];
            for($i=0;$i < count(request()->pengalamanKerja);){
                array_push($allpengalamanKerja, json_encode([
                    'nama_perusahaan' => request()->pengalamanKerja[$i++],
                    'jabatan' => request()->pengalamanKerja[$i++],
                    'tahun_awal' => request()->pengalamanKerja[$i++],
                    'tahun_akhir' => request()->pengalamanKerja[$i++],
                    'alasan' => request()->pengalamanKerja[$i++],
                ]));
            }

            $userDetail->pengalaman_bekerja = json_encode($allpengalamanKerja);
        }

        if(request()->pengalamanKerja[0] != null){
            $allpengalamanMengajar = [];
            for($i=0;$i < count(request()->pengalamanMengajar);){
                array_push($allpengalamanMengajar, json_encode([
                    'nama_lembaga' => request()->pengalamanMengajar[$i++],
                    'materi' => request()->pengalamanMengajar[$i++],
                    'tahun_awal' => request()->pengalamanMengajar[$i++],
                    'tahun_akhir' => request()->pengalamanMengajar[$i++],
                    'alasan' => request()->pengalamanMengajar[$i++],
                ]));
            }
            $userDetail->pengalaman_mengajar = json_encode($allpengalamanMengajar);
        }


        $userDetail->kk_mengajar_matkul = request()->kk_mengajar_matkul;
        $userDetail->kk_software_dikuasai = request()->kk_software_dikuasai;
        $userDetail->kk_bahasa_pemograman = request()->kk_bahasa_pemograman;
        $userDetail->kk_hardware_dikuasai = request()->kk_hardware_dikuasai;
        $userDetail->kk_menguasai_jaringan = request()->kk_menguasai_jaringan;
        $userDetail->kk_jaringan_dikuasai = request()->kk_jaringan_dikuasai;
        $userDetail->kk_sofware_pernah_dibuat = request()->kk_sofware_pernah_dibuat;
        $userDetail->kk_sofware_pernah_dibuat_detail = request()->kk_sofware_pernah_dibuat_detail;
        $userDetail->kk_sofware_pernah_dibuat_bahasa_pemograman = request()->kk_sofware_pernah_dibuat_bahasa_pemograman;
        $userDetail->kk_mengarang_buku = request()->kk_mengarang_buku;
        $userDetail->kk_mengarang_buku_judul = request()->kk_mengarang_buku_judul;
        $userDetail->kk_mengarang_buku_penerbit = request()->kk_mengarang_buku_penerbit;
        $userDetail->kk_mengarang_buku_tahun_penerbit = request()->kk_mengarang_buku_tahun_penerbit;
        $userDetail->kk_keahlian_diluar_komputer = request()->kk_keahlian_diluar_komputer;
        $userDetail->olah_raga = request()->olah_raga;
        $userDetail->macam_olahraga = request()->macam_olahraga;
        $userDetail->sakit_berat = request()->sakit_berat;
        $userDetail->macam_sakit_berat = request()->macam_sakit_berat;
        $userDetail->kecelakaan_berat = request()->kecelakaan_berat;
        $userDetail->jenis_kecelakaan = request()->jenis_kecelakaan;
        $userDetail->bila_mana_kecelakaan = request()->bila_mana_kecelakaan;
        $userDetail->akibat_kecelakaan = request()->akibat_kecelakaan;

        $userDetail->save();

        if($userDetail){
            return view('employee.index')->with('success','Data berhasil disimpan!');
        }

        return view('employee.form')->with('danger','Terjadi masalah!');
    }

    public function apiEmployee(){
        $item = User::select('users.id', 'users.name', 'users.email', 'users_detail.phone_mobile')
                    ->leftJoin('users_detail', 'users_detail.users_id', '=', 'users.id')
                    ->orderBy('users_detail.created_at', 'DESC')
                    ->get();

        return Datatables::of($item)
                ->addIndexColumn()
                ->addColumn('phone_mobile', function($item){
                    if($item->phone_mobile == NULL){
                        return 'Tidak tersedia';
                    }
                    return $item->phone_mobile;
                })
                ->addColumn('action', function($item){
                    return 
                    // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> '.
                    '<a href="'.route("employee.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                    '<form id="delete-form-'.$item->id.'" method="post" action="'.route("employee.delete",$item->id).'" style="display: none">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                    </form>'.
                    '<a
                    onclick="
                    if(confirm(\'Are you sure, You Want to delete '.$item->name.'?\'))
                        {
                            event.preventDefault();
                            document.getElementById(\'delete-form-'.$item->id.'\').submit();
                        }else{
                            event.preventDefault();
                    }" 
                    class=""><svg viewBox="0 0 24 24" width="18" height="18" stroke="#dc3545" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                })->rawColumns(['phone_mobile','action'])->make(true);
    }
}
