<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NavSavingsModel;
use Auth;

class NavSavingsController extends Controller
{
    //
    public function getNavHistory(){
        $data['getRecord'] = NavSavingsModel::getNavHistory();
        #$data['header_title'] = "Admin list";
        return view('admin.nav_savings.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.nav_savings.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        $sh = new NavSavingsModel;
        $sh->bank_code = trim($request->bank_code);
        $sh->money_saving = $request->money_saving;
        $sh->money_deposit = $request->money_deposit;
        $sh->deposit_rate = $request->deposit_rate;
        $sh->start_time = $request->start_time;
        $sh->end_time = $request->end_time;
        $sh->note = $request->note;
        $diff = abs(strtotime($request->end_time) - strtotime($request->start_time));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor($diff / (60*60*24));
        $sh->money_deposit = $request->money_saving * $request->deposit_rate / 100 * $days / 365;
        $sh->save();
        return redirect('admin/nav_savings/list')->with('success', "Thêm bản ghi mới thành công");
    }

    public function edit($id){
        $data['getRecord'] = NavSavingsModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit";
            return view('admin.nav_savings.edit',$data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request){
        $sh = NavSavingsModel::getSingle($id);
        $sh->bank_code = trim($request->bank_code);
        $sh->money_saving = $request->money_saving;
        $sh->money_deposit = $request->money_deposit;
        $sh->deposit_rate = $request->deposit_rate;
        $sh->start_time = $request->start_time;
        $sh->end_time = $request->end_time;
        $sh->note = $request->note;
        $diff = abs(strtotime($request->end_time) - strtotime($request->start_time));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor($diff / (60*60*24));
        $sh->money_deposit = $request->money_saving * $request->deposit_rate / 100 * $days / 365;
        $sh->save();
        return redirect('admin/nav_savings/list')->with('success', "Cập nhật bản ghi thành công");
    }

    public function delete($id){
        $save = NavSavingsModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        //return redirect('admin/class/list')->with('success', "Calss successfully deleted");
        return redirect()->back()->with('success', "Xóa bản ghi thành công");
    }
}
