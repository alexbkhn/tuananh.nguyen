<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class NoteToDoModel extends Model
{
    use HasFactory;

    protected $table = 'note_to_do';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getNoteToDo(){
        $return = NoteToDoModel::select('note_to_do.*')
                ->where('note_to_do.is_delete','=',0);
                if(!empty(Request::get('s_work'))){
                    $return = $return->where('work', 'like', '%'.Request::get('s_work').'%');
                }
                if(!empty(Request::get('s_detail'))){
                    $return = $return->where('detail', 'like', '%'.Request::get('s_detail').'%');
                }
                if(!empty(Request::get('s_created_at'))){
                    $return = $return->where('created_at', '=', Request::get('s_created_at'));
                }
                if(!empty(Request::get('s_priority'))){
                    $return = $return->where('priority', '=', Request::get('s_priority'));
                }
                
        $return = $return->orderBy('created_at','desc')
                        ->paginate(20);

        return $return;
    }
}
