<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categori;
use App\Event;


class CategoriController extends Controller
{
  public $data = [];

    public function index()
    {
        $categories = Categori::all();
        foreach ($categories as $category) {
            $this->data[] = [
                'id' => $category->id,
                'image' => $category->image,
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
        $category = Categori::where('id', $id)->first();

        return response()->json($category, 200);
    }

    public function showDonation($id)
    {
        // dd($id);
        $category = Event::where('category_id', $id)->get();

        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $category = Categori::create($request->except('image'));
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . '/assets/images/category';
            $uploaded_gambar->move($destinationPath, $filename);
            $category->image = $filename;
        }
        $category->save();

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Categori::findOrFail($id);
        $category->update($request->except('image'));
        if ($request->hasFile('image')) {
            $uploaded_gambar = $request->file('image');
            $extension = $uploaded_gambar->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . '/assets/images/category';
            $uploaded_gambar->move($destinationPath, $filename);
            $category->image = $filename;
        }
        $category->save();

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Categori::findOrFail($id);
        $category->delete();

        return response()->json($category, 204);
    }

    public function getDataTableJson(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'image',
                            2 => 'name',
                        );
  
        $totalData = Categori::count();
            
        $totalFiltered = $totalData; 
        // dd($request->input('cari'));
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir =  $request->input('order.0.dir');
        // dd($dir);
            
        if(empty($request->input('search.value')))
        {            
            $categories = Categori::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $categories =  Categori::where('id','LIKE',"%{$search}%")
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
        if(!empty($categories))
        {
            foreach ($categories as $category)
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
