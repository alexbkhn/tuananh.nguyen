<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NoteToDoModel;
use Auth;



class NoteToDoController extends Controller
{
    //
    public function getNoteToDo(){
        $data['getRecord'] = NoteToDoModel::getNoteToDo();
        #$data['getStockCompany'] = StockCompanyModel::getStockCompany();
        #$data['header_title'] = "Admin list";
        return view('admin.note_to_do.list',$data);
    }

    public function add(){
        $data['header_title'] = "Add new";
        return view('admin.note_to_do.list',$data);
    }

    public function insert(Request $request){
        #dd($request->all()); 
        
        $sh = new NoteToDoModel;
        $sh->work = trim($request->work);
        $sh->detail = trim($request->detail);
        $sh->priority = trim($request->priority);
        $sh->state = trim($request->state);
        $sh->deadline = trim($request->deadline);
        $sh->save();
        return redirect('admin/note_to_do/list')->with('success', "Thêm bản ghi mới thành công");
    }

    public function edit($id){
        $data['getRecord'] = NoteToDoModel::getSingle($id);
        #$data['getStockCompany'] = StockCompanyModel::getStockCompany();
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit";
            return view('admin.note_to_do.edit',$data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request){
        $sh = NoteToDoModel::getSingle($id);
        $sh->work = trim($request->work);
        $sh->detail = trim($request->detail);
        $sh->priority = trim($request->priority);
        $sh->save();
        return redirect('admin/note_to_do/list')->with('success', "Cập nhật bản ghi thành công");
        //return redirect()->back()->back();
    }

    public function delete($id){
        $save = NoteToDoModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();
        //return redirect('admin/class/list')->with('success', "Calss successfully deleted");
        return redirect()->back()->with('success', "Xóa bản ghi thành công");
    }
}
