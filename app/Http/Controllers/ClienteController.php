<?php
         
namespace App\Http\Controllers;
          
use App\Models\Cliente;
use Illuminate\Http\Request;
use DataTables;
        
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        $clientes = Cliente::latest()->get();

        if ($request->ajax()) {
            $data = Cliente::latest()->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_cliente.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCliente">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_cliente.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCliente">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('cliente',compact('clientes'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        var_dump($request);
        exit (0);
        Cliente::updateOrCreate(['id_cliente' => $request->id_cliente],
                ['id_cliente' => $request->id_cliente, 'author' => $request->author]);        
   
        return response()->json(['success'=>'Cliente saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $Cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        var_dump($cliente);
        exit (0);
        return response()->json($Cliente);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $Cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
  
        Cliente::find($id)->delete();
     
        return response()->json(['success'=>'Cliente deleted successfully.']);
    }
}