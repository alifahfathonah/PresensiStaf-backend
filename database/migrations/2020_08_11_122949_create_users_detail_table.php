<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("users_id");
            $table->string('full_name', 100);
            $table->string('nick_name', 50);
            $table->string('birth_city', 50);
            $table->date('birth_date');
            $table->text('address');
            $table->string('address_city', 50);
            $table->bigInteger('address_postal_code');
            $table->bigInteger('phone_office');
            $table->bigInteger('phone_mobile');
            $table->bigInteger('phone_home');
            $table->enum('religion', ['Islam', 'Katholik', 'Kristen', 'Budha', 'Hindu']);
            $table->bigInteger('card_identity_number');
            $table->string('number_of_siblings', 5);
            $table->enum('status', ['Menikah', 'Belum Menikah', 'Janda', 'Duda']);
            $table->string('nama_istri_suami', 32);
            $table->string('pekerjaan_istri_suami', 32);
            $table->smallInteger('jumlah_anak');
            $table->text('anak'); // di isi array object nama,jenis_kelamin,tanggal_lahir,pekerjaan_pendidikan
            $table->string('nama_darurat', 32);
            $table->text('address_darurat');
            $table->bigInteger('tlp_darurat');
            $table->string('nama_ayah', 32);
            $table->string('pekerjaan_ayah', 32);
            $table->text('alamat_ayah');
            $table->string('nama_ibu', 32);
            $table->string('pekerjaan_ibu', 32);
            $table->text('alamat_ibu');
            // pf = pendidikan formal
            $table->text('pendidikan_formal'); // di isi array object pendidikan,nama_sekolah,tempat,tahun_lulus
            $table->text('pendidikan_nonformal'); // di isi array object macam,instansi,tempat,tahun
            $table->text('kehidupan_berorganisasi'); // di isi array object nama,jabatan,tahun,tempat
            $table->text('pengalaman_bekerja'); // di isi array object nama_perusahaan,jabatan,tahun_awal,tahun_akhir,alasan_berhenti
            $table->text('pengalaman_mengajar'); // di isi array object nama_lembaga,materi,tahun_awal,tahun_akhir,alasan_berhenti

            // kk = keahlian komputer
            $table->string('kk_mengajar_matkul', 50);
            $table->string('kk_software_dikuasai', 60);
            $table->string('kk_bahasa_pemograman', 60);
            $table->string('kk_hardware_dikuasai', 60);
            $table->enum('kk_menguasai_jaringan', ['Ya', 'Tidak']);
            $table->text('kk_jaringan_dikuasai'); // di isi array nama_bidang
            $table->string('kk_sofware_pernah_dibuat', 60);
            $table->text('kk_sofware_pernah_dibuat_detail');
            $table->string('kk_sofware_pernah_dibuat_bahasa_pemograman', 60);
            $table->enum('kk_mengarang_buku', ['Ya', 'Tidak']);
            $table->string('kk_mengarang_buku_judul', 60);
            $table->string('kk_mengarang_buku_penerbit', 60);
            $table->smallInteger('kk_mengarang_buku_tahun_penerbit');
            $table->text('kk_keahlian_diluar_komputer');

            $table->enum('olah_raga', ['Aktif', 'Pasif']);
            $table->text('macam_olahraga');
            $table->enum('sakit_berat', ['Ya', 'Tidak']);
            $table->string('macam_sakit_berat', 60);
            $table->enum('kecelakaan_berat', ['Ya', 'Tidak']);
            $table->string('jenis_kecelakaan', 60);
            $table->string('bila_mana_kecelakaan', 60);
            $table->string('akibat_kecelakaan', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_detail');
    }
}
