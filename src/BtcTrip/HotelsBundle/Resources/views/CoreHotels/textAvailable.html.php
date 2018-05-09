<?php $available=$hotelAvailable->availability[0];?>

<?php $hotel=$available->hotel;  ?>
<?php if (count($available->rooms)== 0){?> 
                <div id="results-error" class="results-error messages-error">
                    <span class="commonSprite warningSymbol"></span>
                    <div class="text">
                        <span class="message" style="">There is no available room for the selected dates.</span>
                        <br>
                        <span class="help">
                            <p>
                                <a id="soldOutLink" class="backToSearch" href="<?php echo $enviromentPrefix?>/hotels/result/<?php echo $hotel->cityId ?>/<?php echo $checkinDate ?>/<?php echo $checkoutDate ?>/<?php echo $distribution?>/1">« Back to search results</a>
                            </p>
                        </span>
                    </div>
               </div>
<?php  } ?>
               