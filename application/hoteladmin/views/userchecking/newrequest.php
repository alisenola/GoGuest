<?php
if (count($checkindata) > 0) {
    for ($i = 0; $i < count($checkindata); $i++) {                                
        $data.= "<tr>
            <td>$checkindata[$i]['userfirstname']</td>
            <td> $checkindata[$i]['hotelname']</td>
            <td>".date('F ,m Y', strtotime($checkindata[$i]['requestdatetime']))."</td>
            <td>
                <a class='btn btn-primary' onclick='changestatus('$checkindata[$i]['checkinid']')' id='cur_$checkindata[$i]['checkinid']'>
                    $checkindata[$i]['status']
                </a>
            </td>
        </tr>";
   
    }
}
?>