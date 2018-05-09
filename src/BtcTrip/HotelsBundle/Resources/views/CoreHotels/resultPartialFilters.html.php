<!-- ############################  FILTROS ################################### -->
<div class="filters" id="filters" style="display: block;">
   <form id="filtersForm">
   <div class="hotels-accordion">
    <h3>Filter by:</h3>
    <div class="accordion-section price">
        <div class="accordion-header accordion-header-open name">
            <h4>Price</h4>
            <span class="accordion-arrow"></span>
        </div>
        <ul class="accordion-content items">
            <li class="item values">
                <ul>
                    <li>
                        <input class="price-min hotels-input" type="text" name="price-min">
                    </li>
                    <li>
                        to 
                    </li>
                    <li>
                        <input class="price-max hotels-input" type="text" name="price-max">
                    </li>
                    <li>
                        <a class="hotels-mini-button apply">
                            <span>Apply</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="item clean">
                <a href="#">Clear filter</a>
            </li>
        </ul>
     </div>    
    
    
    
    <div id="facets_load"></div>
        <?php 
        if (isset($hotels->result->data->facets)){
            $facets=$hotels->result->data;?>
        <?php $facets=$facets->facets ?>
        <?php foreach($facets as $f){?>
        <?php   $valores=array();
                if (isset($f->values)){
                    $valores=$f->values;
                }
        ?>
    
        <?php if ($f->key != 'paymenttype'){?>
        <?php if (count($valores)>0){?> 
        
              <div class="accordion-section <?php echo $f->key; ?>">
                    <div class="accordion-header accordion-header-open name">
                        <h4><?php echo ucwords($f->key);?></h4>
                        <span class="accordion-arrow"></span>
                    </div>
                    <ul class="items accordion-content" data-<?php echo $f->key; ?>-info='{ "name" : "allowedStopQuantities" }'>
                        <li class="item <?php echo $f->key; ?>-all">
                                <label for="<?php echo $f->key; ?>-all" class="selected disabled">
                                <input id="<?php echo $f->key; ?>-all" class="all" type="checkbox" name="<?php echo $f->key;?>" value="NA" checked disabled>
                                <strong class="custom-label">All <?php echo $f->key;?></strong>
                                <strong class="total" id="total_filtro_<?php echo $f->key;?>"><!--{{filterCount data.refinementSummary.stops}}--></strong>
                                </label>
                        </li>
                        <?php $cantidad_parcial_filtro=0;?> 
                        <?php $cantidad_temp_seleccion=0;?>
                      
                            <?php foreach($valores as $v){?>
                             <li class="item <?php echo $f->key;?>-<?php echo $v->id; ?>">
                                      
                                 <?php if (isset($filterParams)){?>
                                    <?php !(strpos($filterParams, $v->id)===false)?  $cantidad_temp_seleccion=$cantidad_temp_seleccion+$v->count : ''?>
                               <?php  } ?>
                             	
                             <label for="<?php echo $f->key; ?>-<?php echo $v->id; ?>" class="">
                                  <?php if (isset($filterParams)){?>
                             <label ab="filter|<?php echo $f->key;?>" class="trackable <?php echo !(strpos($filterParams, $v->id)===false)? "ux-common-filter-selected" : ''?>  ">
                                <?php  }else{?>
                            <label ab="filter|<?php echo $f->key;?>" class="trackable ">
                            
                             <?php } ?>
                                 <input id="<?php echo $f->key;?>-<?php echo $v->id;?>" type="checkbox" name="<?php echo $f->key; ?>" value="<?php echo $v->id; ?>" class="filter<?php echo $f->key;?> ajaxResultCall" type="checkbox" <?php echo !(strpos($filterParams, $v->id)===false)? 'checked="checked"' : ''?> onclick="aplicarFiltro()">
                                <span class="custom-label"><?php echo $v->description?></span>
                                <span class="total"><?php echo $v->count;?></span>
                             </label>
                                  <?php $cantidad_parcial_filtro=$cantidad_parcial_filtro+$v->count;?> 
                              </li>
                        <?php } ?>
                         <script>$("#total_filtro_<?php echo $f->key;?>").html(<?php echo (empty($cantidad_temp_seleccion))? $cantidad_parcial_filtro : $cantidad_temp_seleccion ; ?>)</script>    
                      
                    </ul>
                    </div>
    
        <?php }?>   
    <?php }?>   
       <?php }?>   
        <?php } ?>
   </div>
</form>
</div>
