<?php
// MODEL OBJECTS :
$comp = new \Model\competition();
$winner = new \Model\winner();
$ticket = new \Model\ticket();
$user = new \Model\user();
$wallet = new \Model\wallet();
$factor = new \Model\factor();
// CONTROLLER OBJECTS :
$ccomp = new \Controller\competition();
$cticket = new \Controller\ticket();


// Competitions' LOOP :

$CheckComps = $comp->Check_Competitions();

/*
 * CHECKING Ended Results
 */
if ($CheckComps['Number_of_Ends_competitions'] > 0 ){
    $Ended_Comps = $CheckComps['FO_ends_actives'];
    foreach ($Ended_Comps as $comp_who_ended){
        $last_comps = $comp->getLast_competition();
        $result = [];
        if (time() - $comp_who_ended['Ends_At'] >= 1200){
        $result = array_merge($result,[$comp_who_ended['Competition_Id'] => $ccomp->Get_result($comp_who_ended['Competition_Id'])]);
            foreach ($result as $check => $item){
                if ($item['status'] == true){
                    $comp->fill_result($item['details']['Competition_id'],"نتیجه اعلام گردید و برنده ها تعیین شدند.");
                }else{
                    if (isset($item['alert'])){
                        switch ($item['alert']){
                            case "not_enough_tickets":
                                $ticket->set_competition_id($item['id']);
                                if ($ticket->return_user_total_bought()) {
                                    $comp->fill_result($item['id'], "تیکت کافی خریداری نشد و تیکت ها به بازیکن ها برگردانده شدند.");
                                    $comp->expire_competition($item['id']);
                                }else{
                                    $comp->fill_result($item['id'], "تیکت ها کافی نیست و پول بازیکنان برنگشته است.");
                                }
                                break;
                        }
                    }elseif (!isset($item['alert'])) {
                        $comp->fill_result($item['id'], $item['cause']);
                        $comp->expire_competition($item['id']);
                    }
                }
            }
        }else{
            $comp->fill_result($comp_who_ended['Competition_Id'],"در انتظار محاسبه نتیجه");
        }
    }
 /*
 *   /CHECKING Ended Results
 */

 if ($CheckComps['Number_of_Started_competitions'] > 0 ){
     $Started_Comps = $CheckComps['FO_started'];
     foreach ($Started_Comps as $comp_who_started){
         $comp->fill_result($comp_who_started['Competition_Id'],"مسابقه آغاز شده است.");
     }
 }
}

// /Competitions' LOOP
