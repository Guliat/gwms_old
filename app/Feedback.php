<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {

    public function getFeedback() {
        $getAllFeedbacks = \DB::table('general_feedbacks')
                            ->leftJoin('users', 'general_feedbacks.general_employee_id', '=', 'users.id')
                            ->select('general_feedbacks.*', 'users.name')
                            ->orderBy('general_feedback_id', 'desc')
                            ->paginate(10);
        return $getAllFeedbacks;
    }
    
    public function storeFeedback($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        
        $rules = array(
            'general_feedback' => 'required|min: 15|max: 500',
        );
        
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        
        if ($validator->fails()) {

            $messages = $validator->messages();

            return redirect('/feedback')->withErrors($validator)->withInput();

        } else {
            \DB::insert('INSERT INTO general_feedbacks '
                        . '(general_employee_id, general_feedback, general_feedback_added, general_feedback_updated) '
                        . 'VALUES (?, ?, ?, ?)', 
                        [$authid,
                         $data['general_feedback'],
                         $now,
                         $now]
                        );
            return redirect('/feedback')->with('feedbackadded', 'ДОБАВЕНО !');
        }
    }

    public function updateFeedback($data) {
        $now = date('Y-m-d');
        \DB::table('general_feedbacks')
                    ->where('general_feedback_id', $data['update_id'])
                    ->update([
                     'general_feedback_status' => $data['general_feedback_status'],
                     'general_feedback_updated' => $now
                    ]);
    }
}
