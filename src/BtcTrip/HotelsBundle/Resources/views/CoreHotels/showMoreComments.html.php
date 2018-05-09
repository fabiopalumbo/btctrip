<div id="common-comments-list">
    <?php
    $hotelReviews = $hotelReviews->reviews;
    $cant_comentario = 1;
    foreach ($hotelReviews as $review) {
        if (!empty($review->comments->description)) {
            ?>

            <div class="ux-common-comment-bubble" id="comment_id" <?php echo ($cant_comentario > 10) ? 'style=display:none' : '' ?>>
                <div class="ux-common-comment-bubble-coluser">
                    <div class="ux-common-comment-bubble-coluser-content">
                        <div class="ux-common-comment-bubble-avatar">

                        </div>
                        <div class="ux-common-comment-bubble-user">
                            <p><?php echo $review->user->name ?>
                                <?php if (!empty($review->user->country)) { ?>
                                    <span class="flagIcon flag-<?php echo strtolower($review->user->country) ?> image" style="height:11px;" title="<?php echo (empty($review->user->country) ? $review->user->country : "" ) ?>"></span>
                                <?php } ?>
                            </p>
                            <p class="ux-common-comment-bubble-date"><?php $review_date = new DateTime($review->reviewDate);
                                echo date_format($review_date, 'j M Y');
                                ?></p>
                        </div>

                    </div>
                </div>
                <div class="ux-common-comment-bubble-colopinion">
                    <div class="ux-common-grid-row ux-common-comment-loading" style="z-index:2">
                        <span class="ux-common-comment-loading-spinner"><?php //  < img src="spinner-white-bg.gif">  ?> </span>
                    </div>
                    <div class="ux-common-comment-bubble-colopinion-content">
                        <span class="ux-common-comment-bubble-colopinion-arrow"></span>
                        <div class="ux-common-comment-bubble-opinion ux-common-comment-bubble-opinion-best">
                            <span class="text"><?php echo $review->comments->description; ?></span>
                        </div>
                        <span class="providers" style="display: none;">Useful: 0, Useless: 0<p>{"code":"HBE","hotelID":"345663}</p></span>
                    </div>
                </div>
                <div class="ux-common-comment-bubble-colguest ">
                    <div class="ux-common-comment-bubble-colguest-content">
                        <div class="ux-common-comment-bubble-verified">
                            Source: <span class="ux-common-comment-source-tripadvisor"><?php echo $review->provider ?></span>
                        </div>
                    </div>
                </div>
                <div class="ux-common-comment-bubble-colrate">
                    <div class="ux-common-comment-bubble-colrate-content">
                        <div class="ux-common-comment-bubble-rate">
                            <em><?php echo ((strlen($review->averageScore) == 3) ? substr($review->averageScore, 0, 2) : substr($review->averageScore, 0, 1) . "." . substr($review->averageScore, 1, 1) ); ?></em> points
                        </div>
                    </div>
                </div>
            </div>  
        <?php $cant_comentario++; ?>
    <?php } ?>
<?php } ?>
</div>