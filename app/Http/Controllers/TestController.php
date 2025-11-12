<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberActivity;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    // Muestra la vista
    public function index()
    {
        return view('test.index');
    }

    // Devuelve datos en formato DataTables
    public function data()
    {
        // Ejemplo simple para verificar que funciona el AJAX
        // Si querés probar con tu modelo real, descomentá la parte de abajo
        $query = MemberActivity::with(['member', 'activity'])
            ->select(['id', 'member_id', 'activity_id', 'created_at']);

        return DataTables::of($query)
            ->addColumn('member', fn($r) => $r->member->first_name . ' ' . $r->member->last_name)
            ->addColumn('activity', fn($r) => $r->activity->name ?? '-')
            ->editColumn('created_at', fn($r) => $r->created_at->format('d/m/Y'))
            ->make(true);
    }

/*


namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    public function members()
    {
        return view('test.members');
    }

public function membersData()
{
    $query = Member::select(['id', 'first_name', 'last_name', 'email']);
    dd($query->get());
}
}
 

*/


}
