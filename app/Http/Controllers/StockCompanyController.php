<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StockCompanyModel;
use Auth;



class StockCompanyController extends Controller
{
    //
    public function getStockCompany(){
        $data['getRecord'] = StockCompanyModel::getStockCompany();
        #$data['header_title'] = "Admin list";
        return view('admin.stock_company.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.stock_company.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        $sh = new StockCompanyModel;
        $sh->stock_company = trim($request->stock_company);
        $sh->stock_company_code = trim($request->stock_company_code);
        $sh->stock_company_fee_ratio = trim($request->stock_company_fee_ratio);
        $sh->save();
        return redirect('admin/stock_company/list')->with('success', "Thêm bản ghi mới thành công");
    }

    public function edit($id){
        $data['getRecord'] = StockCompanyModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit";
            return view('admin.stock_company.edit',$data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request){
        $sh = StockCompanyModel::getSingle($id);
        $sh->stock_company = trim($request->stock_company);
        $sh->stock_company_code = trim($request->stock_company_code);
        $sh->stock_company_fee_ratio = trim($request->stock_company_fee_ratio);
        $sh->save();
        return redirect('admin/stock_company/list')->with('success', "Cập nhật bản ghi thành công");
    }

    public function delete($id){
        $save = StockCompanyModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        //return redirect('admin/class/list')->with('success', "Calss successfully deleted");
        return redirect()->back()->with('success', "Xóa bản ghi thành công");
    }
}
