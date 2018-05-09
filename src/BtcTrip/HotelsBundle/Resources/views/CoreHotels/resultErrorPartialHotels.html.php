<div id="results-error" class="results-error messages-error">
<span class="commonSprite warningSymbol"></span>
<div class="text">
    
<span class="message" style=""><?php echo (!isset($hotels->meta->total))? $hotels->errors[0]->description : "We don't have hotels availability for this search. Please try a new date." ?> </span>
</div>
</div>