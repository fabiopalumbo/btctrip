<?php if ((count($hotelReviews->reviews) > 0)&&($parcial_comentarios < $total_comentarios)) { ?>  
    <a class="ux-common-comment-more-button" onclick='javascript:showMoreComment(<?php echo $page ?>,<?php echo $parcial_comentarios?>,<?php echo $total_comentarios?>);'>
        <span class="ux-common-load-btn"></span> <span>See more comments ↓</span>
    </a>
    <p class="ux-common-comment-more-description"><?php echo $parcial_comentarios?> to <?php echo $total_comentarios  ?> comments </p>

<?php } ?>