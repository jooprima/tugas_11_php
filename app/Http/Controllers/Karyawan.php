<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_karyawan;
use Illuminate\Support\Facades\DB;

class Karyawan extends Controller
{
    public function getData(){
      $data = DB::table('tbl_karyawan')->get();
      if (count($data) > 0) {
        $res['message'] = "Success!";
        $res['value'] = $data;
        return response($res);
      }else {
        $res['message'] = "Empty!";
        return response($res);
      }
    }

    public function store(Request $request){
      $this->validate($request, [
        'file' => 'required|max:2048'
      ]);
      //menyimpan data file yang diupload ke variabel $file
      $file = $request->file('file');
      $nama_file = time()."_".$file->getClientOriginalName();
      //isi dengan nama folder tempat kemana file diupload
      $tujuan_upload = 'data_file';
      if ($file->move($tujuan_upload,$nama_file)) {
        $data = tbl_karyawan::create([
          'nama' => $request->nama,
          'jabatan' => $request->jabatan,
          'umur' => $request->umur,
          'alamat' => $request->alamat,
          'foto' => $nama_file
        ]);
        $res['message'] = "Success!";
        $res['values'] = $data;
        return response($res);
      }
    }

    public function update(Request $request){
      if (!empty($request->file)) {
        $this->validate($request, [
          'file' => 'required|max:2048'
        ]);
        //menyimpan data file yang diupload ke variable $file
        $file = $request->file('file');
        $nama_file = time()."_".$file->getClientOriginalName();
        //isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload,$nama_file);
        $data = DB::table('tbl_karyawan')->where('id',$request->id)->get();
        foreach($data as $karyawan){
          @unlink(public_path('data_file/'.$karyawan->foto));
          $ket = DB::table('tbl_karyawan')->where('id',$request->id)->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'foto' => $nama_file
          ]);
          $res['message'] = "Success!";
          $res['values'] = $data;
          return response($res);
        }
      }else {
        $data = DB::table('tbl_karyawan')->where('id',$request->id)->get();
        foreach($data as $karyawan){
          $ket = DB::table('tbl_karyawan')->where('id',$request-id)->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'umur' => $request->umur,
            'alamat' => $request->alamat
          ]);
          $res['message'] = "Success!";
          $res['values'] = $data;
          return response($res);
        }
      }
    }

    public function hapus($id){
    $data = DB::table('tbl_karyawan')->where('id',$id)->get();
    foreach ($data as $karyawan){
      if (file_exists(public_path('data_file/'.$karyawan->foto))) {
        @unlink(public_path('data_file/'.$katalog->foto));
        DB::table('tbl_karyawan')->where('id',$id)->delete();
        $res['message'] = "Success!";
        return response($res);
      }else {
        $res['message'] = "Empty!";
        return response($res);
      }
    }
  }

  public function getDetail($id){
    $data = DB::table('tbl_karyawan')->where('id',$id)->get();
    if (count($data) > 0) {
      $res['message'] = "Success!";
      $res['value'] = $data;
      return response($res);
    }else {
      $res['message'] = "Empty!";
      return response($res);
    }
  }
}
