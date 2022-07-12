<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_wf_tr_visitation;
use App\Models\tb_wf_tr_visitation_detail;
use App\Models\tb_wf_tr_visitation_right_party;
use App\Converter\ModelConverter;

class tb_wf_tr_visitation_controller extends Controller
{
    public function get_by_date_range(Request $request) {

        $visitations = tb_wf_tr_visitation::with(['visitation_details', 'visitation_details.contract'])
            ->whereBetween("date", [$request->date_from, $request->date_to])
            ->where("user_id", auth()->user()->user_id)
            ->get();

        $visitations = ModelConverter::to_visitation_rowmanager($visitations);

        return response()->json([
            "status" => "Success",
            "data" => $visitations
        ]);
    }

    public function get(Request $request) {

        $visitation = tb_wf_tr_visitation::with(['visitation_details', 'visitation_details.contract'])
            ->find($request->id);

        $visitation = ModelConverter::to_visitation_entry($visitation);

        return response()->json([
            "status" => "Success",
            "data" => $visitation
        ]);
    }
    
    public function get_entry(Request $request) {
        $visitation_detail = tb_wf_tr_visitation_detail::with(['contract', 'negative', 'right_party', 'third_party'])
        ->find($request->id);

        $visitation_detail = ModelConverter::to_visitation_detail_entry($visitation_detail);

        return response()->json([
            "status" => "Success",
            "data" => $visitation_detail
        ]);
    }

    public function update_entry(Request $request) {

        try {
            $visitation_detail = tb_wf_tr_visitation_detail::find($request->id);
            $visitation_detail->date_visited = $request->date_visited;
    
            if ($request->right_party !== false) {

                $right_party = $request->right_party;
    
                if ($visitation_detail->right_party === null) {
                    $visitation_detail->right_party()->create($right_party);
                }
                else {
                    $visitation_detail->right_party()->update($right_party);
                }
                $visitation_detail->third_party()->delete();
                $visitation_detail->negative()->delete();
            }

            else if ($request->third_party !== false) {

                $third_party = $request->third_party;
    
                if ($visitation_detail->third_party === null) {
                    $visitation_detail->third_party()->create($third_party);
                }
                else {
                    $visitation_detail->third_party()->update($third_party);
                }
                $visitation_detail->right_party()->delete();
                $visitation_detail->negative()->delete();
            }

            else if ($request->negative !== false) {

                $negative = $request->negative;
    
                if ($visitation_detail->negative === null) {
                    $visitation_detail->negative()->create($negative);
                }
                else {
                    $visitation_detail->negative()->update($negative);
                }
                $visitation_detail->right_party()->delete();
                $visitation_detail->third_party()->delete();
            }
    
            $visitation_detail->save();
    
            return response()->json([
                "status" => "Success"
            ]);
        }

        catch (Exception $e) {
            return response()->json([
                "status" => "Failed",
                "message" => $e->getMessage()
            ]);
        }
    }
}
