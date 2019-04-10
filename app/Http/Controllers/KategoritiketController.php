<?php

namespace App\Http\Controllers;

use App\Kategoritiket;
use App\Tiket;
use Illuminate\Http\Request;

class KategoritiketController extends Controller
{
  public $data = [];

    public function index()
    {
        $Katiket = Kategoritiket::all();
        foreach ($Katiket as $category) {
            $this->data[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }
        // var_dump(data);

        $dataJSON = ['data'=>$this->data]; 
        return response()->json($dataJSON, 200);
    }

    public function show($id)
    {
        // dd($id);
        $Katiket = Kategoritiket::where('id', $id)->first();

        return response()->json($Katiket, 200);
    }

    public function showTiket($id)
    {
        // dd($id);
        $Katiket = Tiket::where('katiket_id', $id)->get();

        return response()->json($Katiket, 200);
    }

    public function store(Request $request)
     {
        $katiket = new Kategoritiket;
        $katiket->name = $request->name;

        $katiket->save();

        return response()->json($katiket, 201);
    }


    public function update(Request $request, $id)
      {
        $Katiket = Kategoritiket::findOrFail($id);
        $Katiket->update($request->all());

        return response()->json($Katiket, 200);
    }

    public function destroy($id)
    {
        $Katiket = Kategoritiket::findOrFail($id);
        $Katiket->delete();

        return response()->json($Katiket, 204);
    }

    public function getDataTableJson(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'image',
                            2 => 'name',
                        );
  
        $totalData = Kategoritiket::count();
            
        $totalFiltered = $totalData; 
        // dd($request->input('cari'));
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir =  $request->input('order.0.dir');
        // dd($dir);
            
        if(empty($request->input('search.value')))
        {            
            $Katiket = Kategoritiket::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $Katiket =  Kategoritiket::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Categori::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($Katiket))
        {
            foreach ($Katiket as $category)
            {
                // $edit =  route('barang.edit',$barang->kode_barang);
                // $hapus =  '/BarangDelete?id='.$barang->kode_barang;
                // $nestedData['kode'] = $barang->id;
                // $nestedData['check']="<input type='checkbox' name='checkitem[]' class='checkitem' value='$barang->kode_barang'>";
                $nestedData['id'] = $category->id;
                $nestedData['image'] = $category->image;
                $nestedData['nama'] = $category->nama;
            //     $nestedData['options'] = '<div class="btn-group mr-1 mb-1">
            //     <button type="button" class="btn btn-icon btn-info dropdown-toggle" data-toggle="dropdown"
            //     aria-haspopup="true" aria-expanded="false"><i class="la la-navicon"></i></button>
            //     <div class="dropdown-menu">
            //     <a class="dropdown-item" onclick="BarangEdit(\''.$edit.'\')" id="barangEdit">Detail</a>
            //     <a class="dropdown-item" onclick="BarangDelete(\''.$hapus.'\')" id="BarangDelete">Hapus</a>
            // </div>
            // </div>';
                $data[] = $nestedData;

            }
        }

        $dataJson = $data;
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $dataJson   
                    );
        //    dd(json_encode($json_data)); 
        return json_encode($json_data); 
        
    }
}
