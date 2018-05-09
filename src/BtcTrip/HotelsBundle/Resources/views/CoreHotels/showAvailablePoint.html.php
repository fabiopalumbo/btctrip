<?php $available=$hotelAvailable->availability[0];?>
<?php $hotel=$available->hotel;  ?>
<?php if ($hotel->reviewSummary->overallRating != 0) { ?>
    <div class="ux-hotels-detail-rate-secondary">
        <div class="ux-hotels-detail-rate-score">
            <?php $overall_rating = $hotel->reviewSummary->overallRating; ?>
            <em><?php echo ((strlen($overall_rating) == 3) ? substr($overall_rating, 0, 2) : substr($overall_rating, 0, 1) . "." . substr($overall_rating, 1, 1) ); ?></em> point
        </div>
        <div class="ux-hotels-detail-rate-text">

            <?php if (($overall_rating >= 70) && ($overall_rating <= 80)) {
                $condicion = "Confort";
            } ?>
    <?php if (($overall_rating > 80) && ($overall_rating < 90)) {
        $condicion = "Very good";
    } ?>
    <?php if (($overall_rating >= 90) && ($overall_rating <= 100)) {
        $condicion = "Excellent";
    } ?>
            <em><?php echo (isset($condicion) ? $condicion : '') ?></em>
        </div>
        <!--<div class="ux-hotels-detail-rate-recommended">
            <span class="ux-common-icon-positive"></span> 80% lo recomendó
        </div>
        -->
    </div>
<?php } ?>
