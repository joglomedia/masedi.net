<div class="mainbox" id="popup_domination_tab_htmlform">
	<div class="inside twodivs">
		<div class="popdom-inner-sidebar">
			<div class="other">
				<h3>Please Fill in the Following Details:</h3>
                <div class="col">
                    <p class="msg">Enter your html opt-in code below and we'll hook up your form to the template:</p>
                    <p><textarea cols="60" rows="10" id="popup_domination_formhtml" name="popup_domination[formhtml]"><?php echo $formhtml?></textarea></p>
                    <div id="hidden-form" style="display:none;" ></div>
                    <?php $new_window = $this->option('new_window'); ?>
            		<p><input type="checkbox" name="popup_domination[new_window]" id="popup_domination_new_window" value="Y" <?php echo ($new_window=='Y') ? 'checked="checked"':'';?>/>
					<label for="popup_domination_new_window">Submit the form to a new window</label></p>
					
					<?php $disable_name = $this->option('disable_name'); ?>
                    <p><input type="checkbox" name="popup_domination[disable_name]" id="popup_domination_disable_name" value="Y" <?php echo ($disable_name=='Y') ? 'checked="checked"':'';?>/>
					<label for="popup_domination_disable_name">Disable name box?</label></p>
                    <p>
                        <label for="popup_domination_name_box"><strong>Name:</strong></label>
                        <select id="popup_domination_name_box" name="popup_domination[name_box]"<?php echo ($disable_name && $disable_name=='Y')?' disabled="disabled"':''; ?>></select>
                        <input type="hidden" id="popup_domination_name_box_selected" value="<?php echo $name_box?>"<?php echo ($disable_name && $disable_name=='Y')?' disabled="disabled"':''; ?> />
                    </p>
                    <p>
                        <label for="popup_domination_email_box"><strong>Email:</strong></label>
                        <select id="popup_domination_email_box" name="popup_domination[email_box]"></select>
                        <input type="hidden" id="popup_domination_email_box_selected" value="<?php echo $email_box?>" />
                    </p>
                    <p><textarea style="display:none" name="popup_domination[hidden_fields]" class="hidden_fields"></textarea></p>
                    <div class="popup_domination_custom_inputs">
                    <?php $number = $this->option('custom_fields'); ?>
                    <?php if(isset($number) && $number != 0): ?>
                    <input type="hidden" id="popup_domination_inputs_num" name="popup_domination[custom_fields]" value="<?php echo $number; ?>" />
                    
                    	<?php for($i=1;$i<=$number;$i++): ?>
              
                    	<?php $str = 'custom'.$i.'_box'; ?>
                            <p>
                                <label for="popup_domination_custom<?php echo $i; ?>_box"><strong>Custom Field <?php echo $i; ?>:</strong></label>
                                <select id="popup_domination_custom<?php echo $i; ?>_box" name="popup_domination[custom<?php echo $i; ?>_box]"></select>
                                <input type="hidden" id="popup_domination_custom<?php echo $i; ?>_box_selected" value="<?php echo $$str; ?>"/>
                            </p>
                        <?php endfor; ?>
                    <?php endif; ?>
                    </div>
                    <p>
                        <label for="popup_domination_action"><strong>Form URL:</strong></label>
                        <input size="60" type="text" id="popup_domination_action" disabled="disabled" name="popup_domination[action]" value="<?php echo $this->input_val($this->option('action'))?>" />
                    </p>
                </div>
            </div>
           	<div class="clear"></div>
		</div>
	</div>
</div>