<?php
if (isset($distribution)) {

    $array_distribution = explode("!", $distribution);
    $cantidad_habitacion = count($array_distribution);
    $cantidad_adultos = 0;
    $array_adultos=array();
    $j=1;
    foreach ($array_distribution as $h) {
        $text = explode("-", $h);
        $array_adultos[$j][0]=$text[0];
        for($i=1;$i<count($text);$i++){
            $array_adultos[$j][1][$i]=$text[$i];
        }
        $j++;
    }   
  //  print_r($array_adultos);
}
?>


<!--  <div class="span4 searchbg">
    <div class="searchform" >  -->
<form id="mainBox" class="searchbox hotels">
    <div class="pdt-hotels ">
<?php if ($showTitle) { ?>
            <h2 class="producttitle">Search hotels</h2>
        <?php } ?> 
        <div class="mod-places-hotels">
            <div class="com-city-hotels destination">
                <label for="sb-destination-hotels" id="lbl-destination-hotels">Destination / Hotel</label>
                <input type="text"  class="sb-destination" id="sb-destination-hotels" placeholder="Enter a city or an hotel name" autocomplete="off" value=""/>
                <p class="error error-empty hidden"><span class="commonSprite errorCrossIcon"></span>
                    <span class="errortext">Please, input a destination city or hotel.</span>
                </p>
                <p class="error error-badcity hidden"><span class="commonSprite errorCrossIcon"></span>
                    <span class="errortext">Please, input a valid destination city or hotel.</span>
                </p>
            </div>
        </div>
        <div class="mod-dates">
            <div class="com-datein">
                <label for="sb-datein-hotels" id="lbl-datein-hotels">Check in</label>
                <input type="text" class="sb-datein" id="sb-datein-hotels" placeholder="dd/mm/yyyy" maxlength=10 autocomplete="off" value="" 
                <?php if (isset($sFromName) && empty($checkinDate) && empty($checkoutDate)) { echo 'disabled' ;}  ?> />
                <span class="commonSprite buttonCalendarOn"></span>
            </div>
            <div class="com-dateout">
                <label for="sb-dateout-hotels" id="lbl-dateout-hotels">Check out</label>
                <input type="text" class="sb-dateout" id="sb-dateout-hotels" placeholder="dd/mm/yyyy" maxlength=10 autocomplete="off" value=""
                <?php if (isset($sFromName) && empty($checkinDate) && empty($checkoutDate)) { echo 'disabled' ;}  ?> />
                <span class="commonSprite buttonCalendarOn"></span>
            </div>
            <p class="error error-emptyIn hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">Please, input a check-in date.</span>
            </p>
            <p class="error error-emptyOut hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">Please, input a check-out date.</span>
            </p>
            <p class="error error-dateIn hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">Please, input a valid check-in date.</span>
            </p>
            <p class="error error-dateOut hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">Please, input a valid check-out date.</span>
            </p>
            <p class="error error-stayIn hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">The check-in date is out of the permited range.</span>
            </p>
            <p class="error error-stayOut hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">The check-out date is out of the permited range.</span>
            </p>
            <p class="error error-range hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">The checkout date must be later than the check-in date</span>
            </p>
            <p class="error error-maxDays hidden"> <span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">The stay should be less than 30 days.</span>
            </p>                     
            <p class="error error-checkDate hidden"><span class="commonSprite errorCrossIcon"></span>
                <span class="errortext">Your check-in and check-out at the hotel must
                    be between the departure and return dates of your flight</span>
            </p>

            <div class="mod-no-dates">
                <input type="checkbox" id="no-dates-cb" value="1"  <?php if (isset($sFromName) && empty($checkinDate) && empty($checkoutDate)) { echo 'checked' ;}  ?> /> <label for="no-dates-cb">I haven’t decided the dates yet</label>
            </div>
        </div>
        <div class="mod-roomsquantity">
            <div class="com-roomquantity">
                <label>Rooms</label>
                <select id="sb-hotels" class="sb-hotels" name="sb-hotels">
                    <option value="1" <?php echo (isset($distribution) && (count($array_distribution)==1))? 'selected="selected"': '' ?>    >1 Room</option>
                    <option value="2" <?php echo (isset($distribution) && (count($array_distribution)==2))? 'selected="selected"': '' ?>>2 Rooms</option>
                    <option value="3" <?php echo (isset($distribution) && (count($array_distribution)==3))? 'selected="selected"': '' ?>>3 Rooms</option>
                    <option value="4" <?php echo (isset($distribution) && (count($array_distribution)==4))? 'selected="selected"': '' ?>>4 Rooms</option>

                </select>
            </div>
        </div>
        <div class="mod-passengers">
            <ul class="ctn-passengers">
                <li class="com-passenger cp-1">
                    <label id="labelroomuno" class="lbl-room-1 hidden">Room 1</label>
                    <div class="ctn-passenger">
                        <div class="ctn-adult ctn-1">
                            <label class="lbl-adults" >Adults</label>
                            <select class="adult" id="adult_id_1" name="dult_id_1">
                                <option value="1" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==1))? 'selected="selected"': '' ?> >1</option>
                                <option value="2" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==2))? 'selected="selected"': '' ?> >2</option>
                                <option value="3" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==3))? 'selected="selected"': '' ?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==4))? 'selected="selected"': '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==5))? 'selected="selected"': '' ?>>5</option>
                                <option value="6" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==6))? 'selected="selected"': '' ?>>6 </option>
                                <option value="7" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==7))? 'selected="selected"': '' ?>>7</option>
                                <option value="8" <?php echo (isset($array_adultos) && (($array_adultos[1][0])==8))? 'selected="selected"': '' ?>>8</option>
                            </select>
                        </div>
                        <div class="ctn-child ctn-1">
                            <label class="lbl-children" >Children</label>
                            <select class="child" id="child_id_1" name="child_id_1">
                                <option value="0" selected="selected" >0</option>
                                <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[1])))? ((count($array_adultos[1][1]))==1)? 'selected="selected"' : '' : '' : '' ?>>1</option>
                                <option value="2"<?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[1]))) ? ((count($array_adultos[1][1]))==2)? 'selected="selected"' : '' : '' : ''  ?> >2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[1])))? ((count($array_adultos[1][1]))==3)? 'selected="selected"' : '' : '' :'' ?>>3</option>
                                <option value="4"<?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[1])))? ((count($array_adultos[1][1]))==4)? 'selected="selected"' : '' : '' : '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[1])))? ((count($array_adultos[1][1]))==5)? 'selected="selected"' : '' : '' :'' ?>>5</option>
                            </select>
                        </div>
                       
                        <div id="div_age_1" class="ctn-age hidden">
                            <label class="lbl-ages" >Children ages</label>
                            <ul class="ctn-selects-ages">
                                <li id="li_age_1_1" class="ctn-selects-age room-1 ctn-1 hidden">
                                    <select class="sb-age" id="age_id_1_1" name="age_id_1_1">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('1', $array_adultos[1][1])))))?  (($array_adultos[1][1][1])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                    </select>
                                </li>
                                <li id="li_age_1_2" class="ctn-selects-age room-1 ctn-2 hidden">
                                    <select class="sb-age" id="age_id_1_2" name="age_id_1_2">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('2', $array_adultos[1][1])))))?  (($array_adultos[1][1][2])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_1_3" class="ctn-selects-age room-1 ctn-3 hidden">
                                    <select class="sb-age" id="age_id_1_3" name="age_id_1_3">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('3', $array_adultos[1][1])))))?  (($array_adultos[1][1][3])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_1_4" class="ctn-selects-age room-1 ctn-4 hidden">
                                    <select class="sb-age" id="age_id_1_4" name="age_id_1_4">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('4', $array_adultos[1][1])))))?  (($array_adultos[1][1][4])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_1_5" class="ctn-selects-age room-1 ctn-5 hidden">
                                    <select class="sb-age" id="age_id_1_5" name="age_id_1_5">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('1', $array_adultos))))? ((((array_key_exists('1', $array_adultos[1])))))? ((((array_key_exists('5', $array_adultos[1][1])))))?  (($array_adultos[1][1][5])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                
                            </ul>
                            <p class="error error-passengerRooms hidden">
                                <span class="commonSprite errorCrossIcon"></span><span class="errortext"></span>
                            </p>
                        </div>
                    </div>
                </li>
                <li id="roomdos" class="com-passenger cp-2 hidden">
                    <label id="labelroomdos"  class="lbl-room-2 hidden">Room 2</label>
                    <div class="ctn-passenger">
                        <div class="ctn-adult ctn-2">
                            <label class="lbl-adults" >Adults</label>
                            <select class="adult" id="adult_id_2" name="adult_id_2">
                                <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==1)? 'selected="selected"' : '' : '' ?> >1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==2)? 'selected="selected"' : '' : '' ?> >2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==3)? 'selected="selected"' : '' : '' ?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==4)? 'selected="selected"' : '' : '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==5)? 'selected="selected"' : '' : '' ?>>5</option>
                                <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==6)? 'selected="selected"' : '' : '' ?>>6 </option>
                                <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==7)? 'selected="selected"' : '' : '' ?>>7</option>
                                <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? (($array_adultos[2][0])==8)? 'selected="selected"' : '' : '' ?>>8</option>
                            </select>
                        </div>
                        <div class="ctn-child ctn-2">
                            <label class="lbl-children" >Children</label>
                            <select class="child" id="child_id_2" name="child_id_2">
                                <option value="0" selected="selected" >0</option>
                                <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[2])))? ((count($array_adultos[2][1]))==1)? 'selected="selected"' : '' : '' : '' ?>>1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[2])))? ((count($array_adultos[2][1]))==2)? 'selected="selected"' : '' : ''  :''?>>2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[2])))? ((count($array_adultos[2][1]))==3)? 'selected="selected"' : '' : '': '' ?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[2])))? ((count($array_adultos[2][1]))==4)? 'selected="selected"' : '' : '':'' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[2])))? ((count($array_adultos[2][1]))==5)? 'selected="selected"' : '' : '' :'' ?>>5</option>
                            </select>
                        </div>
                        <div id="div_age_2" class="ctn-age hidden">
                            <label class="lbl-ages" >Children ages</label>
                            <ul class="ctn-selects-ages">
                                <li id="li_age_2_1" class="ctn-selects-age room-2 ctn-1 hidden">
                                    <select class="sb-age" id="age_id_2_1" name="age_id_2_1">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('1', $array_adultos[2][1])))))?  (($array_adultos[2][1][1])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_2_2" class="ctn-selects-age room-2 ctn-2 hidden">
                                    <select class="sb-age" id="age_id_2_2" name="age_id_2_2">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('2', $array_adultos[2][1])))))?  (($array_adultos[2][1][2])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_2_3" class="ctn-selects-age room-2 ctn-3 hidden">
                                    <select class="sb-age" id="age_id_2_3" name="age_id_2_3">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                          <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('3', $array_adultos[2][1])))))?  (($array_adultos[2][1][3])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_2_4" class="ctn-selects-age room-2 ctn-4 hidden">
                                    <select class="sb-age" id="age_id_2_4" name="age_id_2_4">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                          <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('4', $array_adultos[2][1])))))?  (($array_adultos[2][1][4])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_2_5" class="ctn-selects-age room-2 ctn-5 hidden">
                                    <select class="sb-age" id="age_id_2_5" name="age_id_2_5">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                          <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('2', $array_adultos))))? ((((array_key_exists('1', $array_adultos[2])))))? ((((array_key_exists('5', $array_adultos[2][1])))))?  (($array_adultos[2][1][5])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                
                            </ul>
                            <p class="error error-passengerRooms hidden">
                                <span class="commonSprite errorCrossIcon"></span>
                                <span class="errortext"></span>
                            </p>
                        </div>
                    </div>
                </li>
                <!--  Parajero 3-->
                <li id="roomtres" class="com-passenger cp-3 hidden">
                    <label id="labelroomtres"  class="lbl-room-3 hidden">Room 3</label>
                    <div class="ctn-passenger">
                        <div class="ctn-adult ctn-3">
                            <label class="lbl-adults" >Adults</label>
                            <select class="adult" id="adult_id_3" name="adult_id_3">
                                 <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==1)? 'selected="selected"' : '' : '' ?> >1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==2)? 'selected="selected"' : '' : '' ?> >2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==3)? 'selected="selected"' : '' : '' ?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) )) ? (($array_adultos[3][0])==4)? 'selected="selected"' : '' : '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==5)? 'selected="selected"' : '' : '' ?>>5</option>
                                <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==6)? 'selected="selected"' : '' : '' ?>>6 </option>
                                <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==7)? 'selected="selected"' : '' : '' ?>>7</option>
                                <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? (($array_adultos[3][0])==8)? 'selected="selected"' : '' : '' ?>>8</option>
                           
                            </select>
                        </div>
                        <div class="ctn-child ctn-3">
                            <label class="lbl-children" >Children</label>
                            <select class="child" id="child_id_3" name="child_id_3">
                                <option value="0" selected="selected" >0</option>
                                <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[3])))? ((count($array_adultos[3][1]))==1)? 'selected="selected"' : '' : '' :'' ?>>1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[3])))? ((count($array_adultos[3][1]))==2)? 'selected="selected"' : '' : '' :''?>>2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[3])))? ((count($array_adultos[3][1]))==3)? 'selected="selected"' : '' : '': '' ?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[3])))?((count($array_adultos[3][1]))==4)? 'selected="selected"' : '' : '': '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[3])))?((count($array_adultos[3][1]))==5)? 'selected="selected"' : '' : '':'' ?>>5</option>
                            </select>
                        </div>
                        <div id="div_age_3" class="ctn-age hidden">
                            <label class="lbl-ages" >Children ages</label>
                            <ul class="ctn-selects-ages">
                                <li id="li_age_3_1" class="ctn-selects-age room-3 ctn-1 hidden">
                                    <select class="sb-age" id="age_id_3_1" name="age_id_3_1">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('1', $array_adultos[3][1])))))?  (($array_adultos[3][1][1])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_3_2" class="ctn-selects-age room-3 ctn-2 hidden">
                                    <select class="sb-age" id="age_id_3_2" name="age_id_3_2">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('2', $array_adultos[3][1])))))?  (($array_adultos[3][1][2])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_3_3" class="ctn-selects-age room-3 ctn-3 hidden">
                                    <select class="sb-age" id="age_id_2_3" name="age_id_2_3">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('3', $array_adultos[3][1])))))?  (($array_adultos[3][1][3])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_3_4" class="ctn-selects-age room-3 ctn-4 hidden">
                                    <select class="sb-age" id="age_id_3_4" name="age_id_3_4">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                       <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('4', $array_adultos[3][1])))))?  (($array_adultos[3][1][4])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_3_5" class="ctn-selects-age room-3 ctn-5 hidden">
                                    <select class="sb-age" id="age_id_3_5" name="age_id_3_5">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('3', $array_adultos))))? ((((array_key_exists('1', $array_adultos[3])))))? ((((array_key_exists('5', $array_adultos[3][1])))))?  (($array_adultos[3][1][5])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                
                            </ul>
                            <p class="error error-passengerRooms hidden">
                                <span class="commonSprite errorCrossIcon"></span>
                                <span class="errortext"></span>
                            </p>
                        </div>
                    </div>
                </li>
                <!-- Fin 3  -->

                <!-- Pasajero 4-->
                <li id="roomcuatro" class="com-passenger cp-4 hidden">
                    <label id="labelroomcuatro"  class="lbl-room-4 hidden">Room 4</label>
                    <div class="ctn-passenger">
                        <div class="ctn-adult ctn-4">
                            <label class="lbl-adults" >Adults</label>
                            <select class="adult" id="adult_id_4" name="adult_id_4">
                                 <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==1)? 'selected="selected"' : '' : '' ?> >1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==2)? 'selected="selected"' : '' : '' ?> >2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==3)? 'selected="selected"' : '' : '' ?>>3</option>
                                <option value="4"<?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==4)? 'selected="selected"' : '' : '' ?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==5)? 'selected="selected"' : '' : '' ?>>5</option>
                                <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==6)? 'selected="selected"' : '' : '' ?>>6 </option>
                                <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==7)? 'selected="selected"' : '' : '' ?>>7</option>
                                <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? (($array_adultos[4][0])==8)? 'selected="selected"' : '' : '' ?>>8</option>
                           
                            </select>
                        </div>
                        <div class="ctn-child ctn-4">
                            <label class="lbl-children" >Children</label>
                            <select class="child" id="child_id_4" name="child_id_4">
                                <option value="0" selected="selected" >0</option>
                                <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[4])))?((count($array_adultos[4][1]))==1)? 'selected="selected"' : '' : '' :''?>>1</option>
                                <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[4])))?((count($array_adultos[4][1]))==2)? 'selected="selected"' : '' : '' : ''?>>2</option>
                                <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[4])))?((count($array_adultos[4][1]))==3)? 'selected="selected"' : '' : '' :''?>>3</option>
                                <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[4])))?((count($array_adultos[4][1]))==4)? 'selected="selected"' : '' : '' : ''?>>4</option>
                                <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos)) ))? ((array_key_exists('1', $array_adultos[4])))?((count($array_adultos[4][1]))==5)? 'selected="selected"' : '' : '' : ''?> >5</option>
                            </select>
                        </div>
                        <div id="div_age_4" class="ctn-age hidden">
                            <label class="lbl-ages" >Children ages</label>
                            <ul class="ctn-selects-ages">
                                <li id="li_age_4_1" class="ctn-selects-age room-4 ctn-1 hidden">
                                    <select class="sb-age" id="age_id_4_1" name="age_id_4_1">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                       <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('1', $array_adultos[4][1])))))?  (($array_adultos[4][1][1])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_4_2" class="ctn-selects-age room-4 ctn-2 hidden">
                                    <select class="sb-age" id="age_id_4_2" name="age_id_4_2">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('2', $array_adultos[4][1])))))?  (($array_adultos[4][1][2])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_4_3" class="ctn-selects-age room-4 ctn-3 hidden">
                                    <select class="sb-age" id="age_id_4_3" name="age_id_4_3">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                         <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('3', $array_adultos[4][1])))))?  (($array_adultos[4][1][3])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                                <li id="li_age_4_4" class="ctn-selects-age room-4 ctn-4 hidden">
                                    <select class="sb-age" id="age_id_4_4" name="age_id_4_4">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==6)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('4', $array_adultos[4][1])))))?  (($array_adultos[4][1][4])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                        
                                    </select>
                                </li>
                                <li id="li_age_4_5" class="ctn-selects-age room-4 ctn-5 hidden">
                                    <select class="sb-age" id="age_id_4_5" name="age_id_4_5">
                                        <option value="-1" disabled="disabled" selected="selected">?</option>
                                        <option value="0" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==0)?  'selected="selected"' : '' : '' : '' : '' ?>>0</option>
                                        <option value="1" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==1)?  'selected="selected"' : '' : '' : '' : '' ?>>1</option>
                                        <option value="2" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==2)?  'selected="selected"' : '' : '' : '' : '' ?>>2</option>
                                        <option value="3" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==3)?  'selected="selected"' : '' : '' : '' : '' ?>>3</option>
                                        <option value="4" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==4)?  'selected="selected"' : '' : '' : '' : '' ?>>4</option>
                                        <option value="5" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==5)?  'selected="selected"' : '' : '' : '' : '' ?>>5</option>
                                        <option value="6" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>6</option>
                                        <option value="7" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==7)?  'selected="selected"' : '' : '' : '' : '' ?>>7</option>
                                        <option value="8" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==8)?  'selected="selected"' : '' : '' : '' : '' ?>>8</option>
                                        <option value="9" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==9)?  'selected="selected"' : '' : '' : '' : '' ?>>9</option>
                                        <option value="10" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==10)?  'selected="selected"' : '' : '' : '' : '' ?>>10</option>
                                        <option value="11" <?php echo (isset($array_adultos) && ((array_key_exists('4', $array_adultos))))? ((((array_key_exists('1', $array_adultos[4])))))? ((((array_key_exists('5', $array_adultos[4][1])))))?  (($array_adultos[4][1][5])==11)?  'selected="selected"' : '' : '' : '' : '' ?>>11</option>
                                   
                                    </select>
                                </li>
                               
                               
                            </ul>
                            <p class="error error-passengerRooms hidden">
                                <span class="commonSprite errorCrossIcon"></span>
                                <span class="errortext"></span>
                            </p>
                        </div>
                    </div>
                </li>

                <!-- -->
            </ul>
        </div>
        <div class="mod-searchbutton">
            <div class="com-searchbutton">
                <a class=" ctn-searchbutton">
                    <input type="image" src="/bundles/btctrip/images/searchbtn.gif">
                </a>
            </div>
        </div>
    </div>

    <input type="hidden" class="sb-destination" id="hidden-destination-hotels"/>
    <input type="hidden" class="sb-destination" id="hidden-destination-type"/>

</form>
