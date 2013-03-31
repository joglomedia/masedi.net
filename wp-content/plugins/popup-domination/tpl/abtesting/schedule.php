<div class="mainbox" id="popup_domination_tab_page_list">
	<div class="inside">
    	<h3>How often should we show popup A?</h3>
    	<span class="line">&nbsp;</span>
    	<span class="example">This is in percentage. For "50%" type in "50".</span>
    	<input type="text" value="<?php if(isset($visitsplit)){echo $visitsplit;}else{ echo '';} ?>" name="numbervisitsplit" class="visitsplit" />
    	<h3>Please specify the conversion page destination:</h3>
    	<span class="line">&nbsp;</span>
    	<span class="example">This has to be a webpage within the blog or website this version of PopUp Domination is installed on.</span>
    	<input type="text" value="<?php if(isset($page)){echo $page;}else{ echo '';} ?>" name="conversionpage" class="conversionpage" />
    </div>
    <div class="clear"></div>
    <div class="inside">
    	<label class="title">Where should we execute this A/B Test?</label>
    	<span class="line">&nbsp;</span>
         <p><?php $this->absplit_list($split['schedule']); ?></p>
    </div>
    <div class="clear"></div>
</div>