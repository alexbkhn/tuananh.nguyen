<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NavHistoryModel;
use Auth;

class NavHistoryController extends Controller
{
    //
    public function getNavHistory(){
        $data['getRecord'] = NavHistoryModel::getNavHistory();
        #$data['header_title'] = "Admin list";
        return view('admin.nav_history.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.nav_history.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        $sh = new NavHistoryModel;
        $sh->transaction_type = trim($request->transaction_type);
        $sh->stock_company_code = trim($request->stock_company_code);
        $sh->nav_date = $request->nav_date;
        $sh->total_money = $request->total_money;
        $sh->total_fee = $request->total_fee;
        $sh->note = $request->note;
        $sh->save();
        return redirect('admin/nav_history/list')->with('success', "Thêm bản ghi mới thành công");
    }

    public function edit($id){
        $data['getRecord'] = NavHistoryModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit";
            return view('admin.nav_history.edit',$data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request){
        $sh = NavHistoryModel::getSingle($id);
        $sh->transaction_type = $request->transaction_type;
        $sh->stock_company_code = trim($request->stock_company_code);
        $sh->nav_date = $request->nav_date;
        $sh->total_money = $request->total_money;
        $sh->total_fee = $request->total_fee;
        $sh->note = $request->note;
        $sh->save();
        return redirect('admin/nav_history/list')->with('success', "Cập nhật bản ghi thành công");
    }

    public function delete($id){
        $save = NavHistoryModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        //return redirect('admin/class/list')->with('success', "Calss successfully deleted");
        return redirect()->back()->with('success', "Xóa bản ghi thành công");
    }
}
