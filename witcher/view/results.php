<?php
$comp = new \Model\competition();
    $competition = new \Controller\competition();
    $competitions = $competition->getResultData();
    $comp_info = $competitions['compets'];
    $winner = new \Model\winner();
    $winner->set_c_id($comp_info['Competition_Id']);
    $first = $winner->get_winner_users()[0];
?>
<div class="footer-container">
    <div class="column">
        <br><h3 class="headline2 cblue">درباره مسابقه</h3>
        <div class="box">
            <style>body {background-color: #3e94ec;font-family: "Roboto", helvetica, arial, sans-serif;font-size: 16pxfont-weight: 400;text-rendering: optimizeLegibility;}div.table-title {
display: block;margin: auto;max-width: 600px;padding:5px;width: 100%;}.table-title h3 {color: #fafafa;font-size: 30px;font-weight: 400;font-style:normal;font-family: "Roboto", helvetica, arial, sans-serif;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
text-transform:uppercase;}.table-fill {background: white;border-radius:3px;border-collapse: collapse;height: 320px;margin: auto; max-width: 600px;padding:5px;width: 100%;box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);animation: float 5s infinite;}
th {color:#D5DDE5;;background:#1b1e24;border-bottom:4px solid #9ea7af;border-right: 1px solid #343a45;font-size:23px;font-weight: 100;padding:24px;text-align:left;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);vertical-align:middle;}th:first-child {border-top-left-radius:3px;}
th:last-child {border-top-right-radius:3px;border-right:none;}tr { border-top: 1px solid #C1C3D1;border-bottom: 1px solid #C1C3D1;color:#666B85;font-size:16px;font-weight:normal;text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);}
tr:hover td {background:#4E5066;color:#FFFFFF;border-top: 1px solid #22262e;}tr:first-child { border-top:none;}tr:last-child {border-bottom:none;}tr:nth-child(odd) td {background:#EBEBEB;}tr:nth-child(odd):hover td { background:#4E5066;}tr:last-child td:first-child {border-bottom-left-radius:3px;}
tr:last-child td:last-child {border-bottom-right-radius:3px;}td { background:#FFFFFF;padding:20px;text-align:left; vertical-align:middle; font-weight:300; font-size:18px; text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1); border-right: 1px solid #C1C3D1;}td:last-child { border-right: 0px;}th.text-left { text-align: left;}th.text-center { text-align: center;}th.text-right {text-align: right;}td.text-left { text-align: left;}td.text-center { text-align: center;}td.text-right {text-align: right;}</style>
            <?php \Model\message::msg_box_session_show();?>
<table class="table-fill">
<thead>
<tr>
<th class="text-left">نام مسابقه</th>
<th class="text-left">قیمت هر تیکت</th>
<th class="text-left">تعداد برنده</th>
<th class="text-left">جایزه نفر اول</th>
<th class="text-left">نتیجه</th>
<th class="text-left">شروع</th>
<th class="text-left">پایان</th>
</tr>
</thead>
<tbody class="table-hover">
    <tr>
        <td class="text-left" style="text-align:center;"><?=$comp_info['Title']?></td>
        <td class="text-left" style="text-align:center;"><?=$comp_info['Tickets_price']?> تومان</td>
        <td class="text-left" style="text-align:center;"><?=$comp_info['Winners_Num']?></td>
        <td class="text-left" style="text-align:center;"><?=$winner->biggest_reward();?><span class="jackpot-fx-symbol before">تومان</span></td>
        <Td class="text-left" style="text-align:center;"><?=$comp_info['Result']?></Td>
        <Td class="text-left" style="text-align:center;"><?=date("Y/m/d H:i:s",$comp_info['Starts_At'])?></Td>
        <Td class="text-left" style="text-align:center;"><?=date("Y/m/d H:i:s",$comp_info['Ends_At'])?></Td>
    </tr>
</tbody>
</table>
        </div>

        <div class="spacer20 show-tablet"></div>
    </div>

</div>