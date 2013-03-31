<?php
			global $post;

			$lcMainKeyword = '';
			if($this->strExists($this->options['unicode_support']))
			{
				$lcMainKeyword = mb_strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'], 'UTF-8');
			}
			else
			{
				$lcMainKeyword = strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword']);
			}



			echo '<div id="onpageseoloader" style="position:relative !important;width:243px !important;text-align:center !important;padding:5px 0 10px 0 !important;font-size:10px !important;">'.__('Loading', OPSEO_TEXT_DOMAIN).'<br /><img src="'.OPSEO_PLUGIN_URL.'/images/ajax_spin.gif" alt="'.__('Loading', OPSEO_TEXT_DOMAIN).'" title="'.__('Loading', OPSEO_TEXT_DOMAIN).'" style="height:16px !important;width:16px !important;border:0 !important;padding-top:3px !important;" /></div>';

			echo '<div class="onpageseoscoremetabox"></div>';

			echo '<div class="onpageseoscore">';

			echo '<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td width="50%" align="center">';

			// Total Rating
			echo '<div class="onpageseometaboxcontainer">';
			echo '<p class="onpageseometaboxcontainerheader">'.__('SEO Score', OPSEO_TEXT_DOMAIN).'</p>';

			if($this->checkKeyword()) { echo '<div id="opseototalscore" class="'.$this->getTotalScoreColorClass($this->postMeta[$lcMainKeyword]['TotalScore']).' onpagegseometaboxscorebox"><p>'.$this->postMeta[$lcMainKeyword]['TotalScore'].'%</p></div>'; }
			else { echo '<div id="opseototalscore" class="'.$this->getTotalScoreColorClass(0).' onpagegseometaboxscorebox"><p>0%</p></div>'; }

			echo '</div>';

			// Keyword Density
			echo '</td><td width="50%" align="center">';

			echo '<div class="onpageseometaboxcontainer">';
			echo '<p class="onpageseometaboxcontainerheader">'.__('Keyword Density', OPSEO_TEXT_DOMAIN).'</p>';

			if($this->checkKeyword()) { echo '<div id="opseokeyworddensityscore" class="'.$this->getKeywordDensityColorClass($this->postMeta[$lcMainKeyword]['KeywordDensityScore']).' onpagegseometaboxscorebox"><p>'.$this->postMeta[$lcMainKeyword]['KeywordDensityScore'].'%</p></div>'; }
			else { echo '<div id="opseokeyworddensityscore" class="'.$this->getKeywordDensityColorClass(0).' onpagegseometaboxscorebox"><p>0%</p></div>'; }

			echo '</div>';

			echo '</td></tr></table><br />';


			echo '<div class="onpageseoerror" onclick="jQuery(\'.onpageseoerror\').hide();"></div>';




			echo '<div id="keyword-tabs">';

			echo '<ul>
					<li class="keywordtabs" style="margin-bottom:0 !important;padding-bottom:0 !important;" onclick="jQuery(this).toggleKeywordTabs(0);"><a href="#keyword-main" onclick="jQuery(this).toggleKeywordTabs(0);"><span id="primarykeywordtext">'.__('Main Keyword', OPSEO_TEXT_DOMAIN).'</span></a></li><li class="keywordtabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:3px !important;" onclick="jQuery(this).toggleKeywordTabs(1);"><a href="#keyword-secondary" onclick="jQuery(this).toggleKeywordTabs(1);"><span id="secondarykeywordtext">Secondary</span></a></li>
				</ul>';

			$mainKeyword = '';

			if($this->strExists($this->options['unicode_support']))
			{
				$mainKeyword = $this->postMeta[mb_strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'], 'UTF-8')]['Keyword'];
			}
			else
			{
				$mainKeyword = $this->postMeta[strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'])]['Keyword'];
			}


			echo '<div id="keyword-main" class="keywords-tabs-panel">

					<table style="border:0 !important;width:100% !important;margin:0 !important;padding:0 !important;" cellspacing="0" cellpadding="0"><tr><td><input type="text" name="mainkeyword" id="mainkeyword" style="padding:8px 10px;width:100% !important;" value="'.$mainKeyword.'" /></td></tr></table>

				</div>

				<div id="keyword-secondary" class="keywords-tabs-panel">

					<table style="border:0 !important;width:100% !important;margin:0 !important;padding:0 !important;" cellspacing="0" cellpadding="0"><tr><td><input type="text" name="secondary-keyword-add" id="secondary-keyword-add" style="padding:8px 10px;width:175px;" value="" /></td><td style="text-align:center !important;"><input type="button" class="button" value="'.__('Add', OPSEO_TEXT_DOMAIN).'" onclick="jQuery(this).addSecondaryKeyword();" /></td></tr>

					<tr><td colspan="2"><select name="secondarykeywords" id="secondarykeywords" style="width:100%;height:75px;margin:7px 0 !important;" size="5">';

					$options = explode('|||', $this->postMeta['onpageseo_global_settings']['SecondaryKeywords']);
					if(sizeof($options) > 0)
					{
						for($i = 0; $i < sizeof($options); $i++)
						{
							if(isset($options[$i]) && (strlen(trim($options[$i])) > 0))
							{
								if($this->strExists($this->options['unicode_support']))
								{
									echo '<option value="'.mb_strtolower($options[$i], 'UTF-8').'">'.$options[$i].'</option>';
								}
								else
								{
									echo '<option value="'.$options[$i].'">'.$options[$i].'</option>';
								}
							}
						}
					}

					echo '</select><input type="hidden" name="allsecondarykeywords" id="allsecondarykeywords" value="" /></td></tr>

					<tr><td colspan="2" style="text-align:center !important;"><input type="button" class="button" value="'.__('Edit', OPSEO_TEXT_DOMAIN).'" onclick="jQuery(this).editSecondaryKeyword();" /> <input type="button" class="button" value="'.__('Delete', OPSEO_TEXT_DOMAIN).'" onclick="jQuery(this).deleteSecondaryKeyword();" /> <input type="button" class="button" value="'.__('Clear All', OPSEO_TEXT_DOMAIN).'" onclick="jQuery(this).clearSecondaryKeywords();" /></td></tr>				

					</table>

				</div>';

			echo '</div>';


			echo '<div id="opseosubmenu">

				<ul class="opseosubmenu-ul">
					<li class="opseosubmenuleft opseosubmenutabs" style="border-left:0 !important;width:75px !important;"><a href="#opseosubmenu-1">Analysis</a></li><li class="opseosubmenucenter opseosubmenutabs" style="width:42px !important;"><a href="#opseosubmenu-2">LSI</a></li><li class="opseosubmenucenter opseosubmenutabs" style="width:90px !important;"><a href="#opseosubmenu-3">Readability</a></li><li class="opseosubmenuright opseosubmenutabs" style="border-right:0 !important;width:50px !important;"><a href="#opseosubmenu-4" onclick="jQuery(this).miscDragAndDrop();">Misc</a></li>
				</ul>


				<div id="opseosubmenu-1" class="opseosubmenu-panel">';


					include_once('admin-suggestion-tabs.php');


				echo '</div>

				<div id="opseosubmenu-2" class="opseosubmenu-panel">

					<div style="width:100% !important;text-align:center !important;margin:0 0 5px 0 !important;padding:0 !important;"><input type="button" class="button" value="'.__('Display LSI Keywords', OPSEO_TEXT_DOMAIN).'" title="'.__('Reload LSI Keywords', OPSEO_TEXT_DOMAIN).'" id="reload-lsi-keywords" /></div>

					<div id="lsikeywordsloader" style="position:relative !important;width:243px !important;text-align:center !important;padding:5px 0 10px 0 !important;font-size:10px !important;">'.__('Loading', OPSEO_TEXT_DOMAIN).'<br /><img src="'.OPSEO_PLUGIN_URL.'/images/ajax_spin.gif" alt="Loading" title="'.__('Loading', OPSEO_TEXT_DOMAIN).'" style="height:16px !important;width:16px !important;border:0 !important;padding-top:3px !important;" /></div>

					<div id="lsi_keywords"></div>

				</div>

				<div id="opseosubmenu-3" class="opseosubmenu-panel">

					<div id="opseoreadability">';

						$gradeAverage = (int)(($this->postMeta['onpageseo_global_settings']['FleschGradeLevel'] + $this->postMeta['onpageseo_global_settings']['GunningFogScore'] + $this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'] + $this->postMeta['onpageseo_global_settings']['SMOGIndex'] + $this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex']) /  5);

						$ageGroup = '';
						$rmClass = '';
						if($gradeAverage < 1) { $ageGroup = 'under 6'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 1) { $ageGroup = '6 to 7'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 2) { $ageGroup = '7 to 8'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 3) { $ageGroup = '8 to 9'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 4) { $ageGroup = '9 to 10'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 5) { $ageGroup = '10 to 11'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 6) { $ageGroup = '11 to 12'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 7) { $ageGroup = '12 to 13'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 8) { $ageGroup = '13 to 14'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 9) { $ageGroup = '14 to 15'; $rmClass='opseoreadabilitymessagetopgreen'; }
						elseif($gradeAverage == 10) { $ageGroup = '15 to 16'; $rmClass='opseoreadabilitymessagetopred'; }
						elseif($gradeAverage == 11) { $ageGroup = '16 to 17'; $rmClass='opseoreadabilitymessagetopred'; }
						elseif($gradeAverage == 12) { $ageGroup = '17 to 18'; $rmClass='opseoreadabilitymessagetopred'; }
						else { $ageGroup = 'over 18'; $rmClass='opseoreadabilitymessagetopred'; }



						echo '<div id="opseoreadabilitymessage" style="margin-bottom:10px !important;"><div id="'.$rmClass.'"></div><p>'.sprintf(__('This content is %s with an average grade level of %s and should be understood by %s year olds.', OPSEO_TEXT_DOMAIN), strtolower($this->postMeta['onpageseo_global_settings']['FleschLevel']), $gradeAverage, $ageGroup).'</p>

						<p id="readabilitystatisticslinkplus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleReadabilityStatistics(1);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">+ '.__('Readability Statistics', OPSEO_TEXT_DOMAIN).'</a></p>
						<p id="readabilitystatisticslinkminus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleReadabilityStatistics(0);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">- '.__('Readability Statistics', OPSEO_TEXT_DOMAIN).'</a></p>

						<p id="readabilitystatistics">&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['SentenceCount'].' '.__('sentences', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['WordCount'].' '.__('words', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['AverageWordsPerSentence'].' '.__('words per sentence', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['AverageSyllablesPerWord'].' '.__('syllables per word', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['ComplexWordsNumber'].' '.__('complex words (3+ syllables)', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['ComplexWordsPercentage'].'% '.__('of words are complex', OPSEO_TEXT_DOMAIN).'</p></div>';

						// Flesch-Kincaid Reading Ease
						$score = $this->postMeta['onpageseo_global_settings']['FleschEase'];
						$left = '';
						$fleschleft = '';
						$class = '';
						if($score >= 90) { $class='readabilitygreenscore'; $left = 'left:179px !important;'; $fleschleft = 'left:179px !important;'; }
						elseif($score >= 80 && $score <= 89.9) { $class='readabilitygreenscore'; $left = 'left:170px !important;'; $fleschleft = 'left:145px !important;'; }
						elseif($score >= 70 && $score <= 79.9) { $class='readabilitygreenscore'; $left = 'left:136px !important;'; $fleschleft = 'left:111px !important;'; }
						elseif($score >= 60 && $score <= 69.9) { $class='readabilitygreenscore'; $left = 'left:102px !important;'; $fleschleft = 'left:77px !important;'; }
						elseif($score >= 50 && $score <= 59.9) { $class='readabilityredscore'; $left = 'left:68px !important;'; $fleschleft = 'left:43px !important;'; }
						elseif($score >= 30 && $score <= 49.9) { $class='readabilityredscore'; $left = 'left:34px !important;'; $fleschleft = 'left:9px !important;'; }
						elseif($score <= 29.9) { $class='readabilityredscore'; $left = 'left:0px !important;'; $fleschleft = 'left:0 !important;'; }

						echo '<p>'.__('Flesch-Kincaid Reading Ease', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore" style="margin-bottom:0 !important;"><div class="'.$class.'" style="'.$left.'">'.$this->postMeta['onpageseo_global_settings']['FleschEase'].'</div></div>';
						echo '<p style="margin-bottom:10px !important;font-size:10px !important;font-style:italic !important;">'.$this->postMeta['onpageseo_global_settings']['FleschLevel'].'</p>';

						// Flesch-Kincaid Grade Level
						echo '<p>'.__('Flesch-Kincaid Grade Level', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore"><div class="'.$class.'" style="'.$fleschleft.'">'.$this->postMeta['onpageseo_global_settings']['FleschGradeLevel'].'</div></div>';

						// Gunning-Fog Score
						$score = $this->postMeta['onpageseo_global_settings']['GunningFogScore'];
						$left = '';
						$class = '';
						if($score < 5) { $class='readabilitygreenscore'; $left = 'left:179px !important;'; }
						elseif($score >= 5 && $score <= 5.9) { $class='readabilitygreenscore'; $left = 'left:170px !important;'; }
						elseif($score >= 6 && $score <= 6.9) { $class='readabilitygreenscore'; $left = 'left:136px !important;'; }
						elseif($score >= 7 && $score <= 8.9) { $class='readabilitygreenscore'; $left = 'left:102px !important;'; }
						elseif($score >= 9 && $score <= 9.9) { $class='readabilitygreenscore'; $left = 'left:68px !important;'; }
						elseif($score >= 10 && $score <= 12) { $class='readabilityredscore'; $left = 'left:34px !important;'; }
						elseif($score >= 12.1) { $class='readabilityredscore'; $left = 'left:0px !important;'; }

						echo '<p>'.__('Gunning-Fog Score', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore"><div class="'.$class.'" style="'.$left.'">'.$this->postMeta['onpageseo_global_settings']['GunningFogScore'].'</div></div>';


						// Coleman-Liau Index
						$score = $this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'];
						$left = '';
						$class = '';
						if($score < 5) { $class='readabilitygreenscore'; $left = 'left:179px !important;'; }
						elseif($score >= 5 && $score <= 5.9) { $class='readabilitygreenscore'; $left = 'left:145px !important;'; }
						elseif($score >= 6 && $score <= 6.9) { $class='readabilitygreenscore'; $left = 'left:111px !important;'; }
						elseif($score >= 7 && $score <= 8.9) { $class='readabilitygreenscore'; $left = 'left:77px !important;'; }
						elseif($score >= 9 && $score <= 9.9) { $class='readabilityredscore'; $left = 'left:43px !important;'; }
						elseif($score >= 10 && $score <= 12) { $class='readabilityredscore'; $left = 'left:9px !important;'; }
						elseif($score >= 12.1) { $class='readabilityredscore'; $left = 'left:0 !important;'; }

						echo '<p>'.__('Coleman-Liau Index', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore"><div class="'.$class.'" style="'.$left.'">'.$this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'].'</div></div>';

						// SMOG Index
						$score = $this->postMeta['onpageseo_global_settings']['SMOGIndex'];
						$left = '';
						$class = '';
						if($score < 5) { $class='readabilitygreenscore'; $left = 'left:179px !important;'; }
						elseif($score >= 5 && $score <= 5.9) { $class='readabilitygreenscore'; $left = 'left:170px !important;'; }
						elseif($score >= 6 && $score <= 6.9) { $class='readabilitygreenscore'; $left = 'left:136px !important;'; }
						elseif($score >= 7 && $score <= 8.9) { $class='readabilitygreenscore'; $left = 'left:102px !important;'; }
						elseif($score >= 9 && $score <= 9.9) { $class='readabilityredscore'; $left = 'left:68px !important;'; }
						elseif($score >= 10 && $score <= 12) { $class='readabilityredscore'; $left = 'left:34px !important;'; }
						elseif($score >= 12.1) { $class='readabilityredscore'; $left = 'left:0px !important;'; }

						echo '<p>'.__('SMOG Index', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore"><div class="'.$class.'" style="'.$left.'">'.$this->postMeta['onpageseo_global_settings']['SMOGIndex'].'</div></div>';

						// Automated Readability Index
						$score = $this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex'];
						$left = '';
						$class = '';
						if($score < 5) { $class='readabilitygreenscore'; $left = 'left:179px !important;'; }
						elseif($score >= 5 && $score <= 5.9) { $class='readabilitygreenscore'; $left = 'left:170px !important;'; }
						elseif($score >= 6 && $score <= 6.9) { $class='readabilitygreenscore'; $left = 'left:136px !important;'; }
						elseif($score >= 7 && $score <= 8.9) { $class='readabilitygreenscore'; $left = 'left:102px !important;'; }
						elseif($score >= 9 && $score <= 9.9) { $class='readabilityredscore'; $left = 'left:68px !important;'; }
						elseif($score >= 10 && $score <= 12) { $class='readabilityredscore'; $left = 'left:34px !important;'; }
						elseif($score >= 12.1) { $class='readabilityredscore'; $left = 'left:0px !important;'; }

						echo '<p>'.__('Automated Readability Index', OPSEO_TEXT_DOMAIN).'</p>';
						echo '<div class="readabilityscore"><div class="'.$class.'" style="'.$left.'">'.$this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex'].'</div></div>';







					echo '</div>

				</div>

				<div id="opseosubmenu-4" class="opseosubmenu-panel">';

					include_once('admin-misc-tabs.php');

				echo '</div>

			</div>';

?>










<script type="text/javascript">

jQuery.extend({
    parseJSON: function( data ) {
        if ( typeof data !== "string" || !data ) {
            return null;
        }    
        data = jQuery.trim( data );    
        if ( /^[\],:{}\s]*$/.test(data.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@")
            .replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]")
            .replace(/(?:^|:|,)(?:\s*\[)+/g, "")) ) {    
            return window.JSON && window.JSON.parse ?
                window.JSON.parse( data ) :
                (new Function("return " + data))();    
        } else {
            jQuery.error( "Invalid JSON: " + data );
        }
    }
});


jQuery(document).ready(function() {

	// Global Variables
	var opseoMainTabSelected = 0;

	// Hide Initial Loader
	jQuery('#onpageseoloader').hide();

	// Hide SEO Report Loader
	jQuery('#onpageseoreportloader').hide();

	// Parse PHP Array
	var keywordSettings = jQuery.parseJSON(<?php print json_encode(json_encode($this->postMeta));?>);

	// Minimum Score
	var opseoMinimumScore = <?php echo $this->minimumScore;?>;

	// Keyword Density
	var opseoKeywordDensityMinimum = <?php echo $this->options['keyword_density_minimum'];?>;
	var opseoKeywordDensityMaximum = <?php echo $this->options['keyword_density_maximum'];?>;


// Update Secondary Keywords
jQuery.fn.updateSecondaryKeywords = function() {
	var secKeywords = '';
	jQuery('#secondarykeywords').find('option').each(function(){ secKeywords += jQuery(this).text() + '|||'; });
	jQuery('#allsecondarykeywords').val(secKeywords);
};

	// SEO Report Thickbox
	var opseoWindowWidth = jQuery(window).width();
	var opseoWindowHeight = jQuery(window).height() - 85;

	jQuery.fn.updateDisplaySEOReportHREF = function(windowHeight) {
		jQuery('a#display-seo-report').attr('href', '#?TB_inline=1&#038;inlineId=myOnPageContent&width=640&height='+windowHeight);
	};

	jQuery(this).updateDisplaySEOReportHREF(opseoWindowHeight);

	jQuery(window).bind('resize', function(e) {
		windowHeight = jQuery(window).height() - 85;
		jQuery(this).updateDisplaySEOReportHREF(windowHeight);
	});



// Update Scores
jQuery.fn.updateOPSEOScores = function(keyword) {

	// Keyword Has Saved Settings
	if(keywordSettings[keyword] !== undefined)
	{
		var className = '';
		var value = '';

		// *** Scores ***

		// Total Score
		value = keywordSettings[keyword]['TotalScore'];
		jQuery('#opseototalscore p').html(value+'%');
		jQuery('#opseototalscore').removeClass();
		if(value >= opseoMinimumScore) { className = 'onpageseogreenscore'; }
		else { className = 'onpageseoredscore'; }
		jQuery('#opseototalscore').addClass(className+' onpagegseometaboxscorebox');

		// Keyword Density
		value = keywordSettings[keyword]['KeywordDensityScore'];
		jQuery('#opseokeyworddensityscore p').html(value+'%');
		jQuery('#opseokeyworddensityscore').removeClass();
		if((value >= opseoKeywordDensityMinimum) && (value <= opseoKeywordDensityMaximum)) { className = 'onpageseogreenscore'; }
		else { className = 'onpageseoredscore'; }
		jQuery('#opseokeyworddensityscore').addClass(className+' onpagegseometaboxscorebox');

		// *** Suggestions ***

		// Keyword Title
		jQuery(this).updateOPSEOSuggestions('#opseokeywordtitle', keywordSettings[keyword]['KeywordTitle']);

		// Keyword Title Beginning
		jQuery(this).updateOPSEOSuggestions('#opseokeywordtitlebeginning', keywordSettings[keyword]['KeywordTitleBeginning']);

		// Title Words
		jQuery(this).updateOPSEOSuggestions('#opseotitlewords', keywordSettings[keyword]['TitleWords']);

		// Title Chars
		jQuery(this).updateOPSEOSuggestions('#opseotitlechars', keywordSettings[keyword]['TitleChars']);

		// *** URL ***

		// Permalink
		jQuery(this).updateOPSEOSuggestions('#opseopermalink', keywordSettings[keyword]['Permalink']);

		// *** Meta Tags ***

		// Description Meta Tag
		jQuery(this).updateOPSEOSuggestions('#opseodescriptionmetatag', keywordSettings[keyword]['DescriptionMetaTag']);

		// Description Meta Tag Length
		jQuery(this).updateOPSEOSuggestions('#opseometataglength', keywordSettings[keyword]['DescriptionMetaTagLength']);

		// Description Meta Tag Beginning
		jQuery(this).updateOPSEOSuggestions('#opseometatagbeginning', keywordSettings[keyword]['DescriptionMetaTagBeginning']);

		// Keywords Meta Tag
		jQuery(this).updateOPSEOSuggestions('#opseokeywordsmetatag', keywordSettings[keyword]['KeywordsMetaTag']);

		// *** Headers ***

		// H1
		jQuery(this).updateOPSEOSuggestions('#opseoh1', keywordSettings[keyword]['H1']);

		// H1 Beginning
		jQuery(this).updateOPSEOSuggestions('#opseoh1beginning', keywordSettings[keyword]['H1Beginning']);

		// H2
		jQuery(this).updateOPSEOSuggestions('#opseoh2', keywordSettings[keyword]['H2']);

		// H3
		jQuery(this).updateOPSEOSuggestions('#opseoh3', keywordSettings[keyword]['H3']);

		// H4
		jQuery(this).updateOPSEOSuggestions('#opseoh4', keywordSettings[keyword]['H4']);

		// H5
		jQuery(this).updateOPSEOSuggestions('#opseoh5', keywordSettings[keyword]['H5']);

		// H6
		jQuery(this).updateOPSEOSuggestions('#opseoh6', keywordSettings[keyword]['H6']);

		// *** Content ***

		// Post Words
		jQuery(this).updateOPSEOSuggestions('#opseopostwords', keywordSettings[keyword]['PostWords']);

		// Keyword Density
		jQuery(this).updateOPSEOSuggestions('#opseokeyworddensity', keywordSettings[keyword]['KeywordDensity']);

		// First 100 Words
		jQuery(this).updateOPSEOSuggestions('#opseofirst100words', keywordSettings[keyword]['First100Words']);

		// Image Exists
		jQuery(this).updateOPSEOSuggestions('#opseoimageexists', keywordSettings[keyword]['ImageExists']);

		// Image ALT
		jQuery(this).updateOPSEOSuggestions('#opseoimagealt', keywordSettings[keyword]['ImageALT']);

		// Bold
		jQuery(this).updateOPSEOSuggestions('#opseobold', keywordSettings[keyword]['Bold']);

		// Italic
		jQuery(this).updateOPSEOSuggestions('#opseoitalic', keywordSettings[keyword]['Italic']);

		// Underline
		jQuery(this).updateOPSEOSuggestions('#opseounderline', keywordSettings[keyword]['Underline']);

		// External Anchor Text
		jQuery(this).updateOPSEOSuggestions('#opseoexternalanchortext', keywordSettings[keyword]['ExternalAnchorText']);

		// Internal Anchor Text
		jQuery(this).updateOPSEOSuggestions('#opseointernalanchortext', keywordSettings[keyword]['InternalAnchorText']);

		// Last 100 Words
		jQuery(this).updateOPSEOSuggestions('#opseolast100words', keywordSettings[keyword]['Last100Words']);

		// Recency
		jQuery(this).updateOPSEOSuggestions('#opseorecency', keywordSettings[keyword]['Recency']);

		// Flesch Kincaid
		jQuery(this).updateOPSEOSuggestions('#opseofleschkincaid', keywordSettings[keyword]['FleschKincaid']);


	}
	// New Keyword - Use Default Settings
	else
	{
		// On-Page SEO Score
		jQuery('#opseototalscore p').html('0.00%');
		jQuery('#opseototalscore').removeClass();
		jQuery('#opseototalscore').addClass('onpageseoredscore onpagegseometaboxscorebox');

		// Keyword Density Score
		jQuery('#opseokeyworddensityscore p').html('0.00%');
		jQuery('#opseokeyworddensityscore').removeClass();
		jQuery('#opseokeyworddensityscore').addClass('onpageseoredscore onpagegseometaboxscorebox');

		// Suggestions
		var suggestionsArr = new Array('opseokeywordtitle', 'opseokeywordtitlebeginning', 'opseotitlewords', 'opseotitlechars', 'opseopermalink', 'opseodescriptionmetatag', 'opseometataglength', 'opseometatagbeginning', 'opseokeywordsmetatag', 'opseoh1', 'opseoh1beginning', 'opseoh2', 'opseoh3', 'opseoh4', 'opseoh5', 'opseoh6', 'opseopostwords', 'opseokeyworddensity', 'opseofirst100words', 'opseoimageexists', 'opseoimagealt', 'opseobold', 'opseoitalic', 'opseounderline', 'opseoexternalanchortext', 'opseointernalanchortext', 'opseolast100words', 'opseorecency');

		for(i = 0; i < suggestionsArr.length; i++)
		{
			jQuery('#'+suggestionsArr[i]).removeClass();
			jQuery('#'+suggestionsArr[i]).addClass('onpageseoscorelifalse');
		}
	}

};


// Update On-Page SEO Suggestions
jQuery.fn.updateOPSEOSuggestions = function(id,value) {

	var className = '';
	jQuery(id).removeClass();
	if(value == 1) { className = 'onpageseoscorelitrue'; }
	else {className = 'onpageseoscorelifalse'; }
	jQuery(id).addClass(className);

};



// Secondary Keywords Select Box Change
jQuery('#secondarykeywords').change(function(){

	// Update Scores
	jQuery(this).updateOPSEOScores(jQuery.trim(jQuery('#secondarykeywords option:selected').val().toLowerCase()));

});



jQuery.fn.toggleKeywordTabs = function(tab) {

	var value = '';

	if(tab == 0)
	{
		// Set Global Variable
		opseoMainTabSelected = 0;

		jQuery('#primarykeywordtext').html('<?php _e('Primary Keyword', OPSEO_TEXT_DOMAIN);?>');
		jQuery('#secondarykeywordtext').html('<?php _e('Secondary', OPSEO_TEXT_DOMAIN);?>');

		// Validate If Main Keyword Exists
		//value = (keywordSettings['onpageseo_global_settings']['MainKeyword'] === undefined) ? '' : jQuery.trim(keywordSettings['onpageseo_global_settings']['MainKeyword'].toLowerCase());

		// Update Scores
		//jQuery(this).updateOPSEOScores(value);
		jQuery(this).updateOPSEOScores(jQuery.trim(jQuery('#mainkeyword').val().toLowerCase()));
	}
	else
	{
		// Set Global Variable
		opseoMainTabSelected = 1;

		jQuery('#primarykeywordtext').html('Primary');
		jQuery('#secondarykeywordtext').html('Secondary Keywords');

		// Validate If Secondary Keyword Is Selected
		value = (jQuery('#secondarykeywords option:selected').val() === undefined) ? '' : jQuery.trim(jQuery('#secondarykeywords option:selected').val().toLowerCase());

		// Update Scores
		jQuery(this).updateOPSEOScores(value);
	}
};

	jQuery(function(){
		jQuery('#readabilitystatisticslinkminus').hide();
		jQuery('#readabilitystatistics').hide();
	});


jQuery.fn.toggleReadabilityStatistics = function(state) {

	if(state == 1)
	{
		jQuery('#readabilitystatisticslinkplus').hide();
		jQuery('#readabilitystatisticslinkminus').show();
		jQuery('#readabilitystatistics').show();
	}
	else
	{
		jQuery('#readabilitystatisticslinkminus').hide();
		jQuery('#readabilitystatistics').hide();
		jQuery('#readabilitystatisticslinkplus').show();
	}
};




	// Display Scores On Load
	jQuery(function(){

		jQuery(this).toggleKeywordTabs(opseoMainTabSelected);

	});







	//jQuery(function(){jQuery('#keyword-tabs').tabs();jQuery('#keyword-tabs').show();});
	//jQuery(function(){jQuery('#suggestion-tabs').tabs();jQuery('#suggestion-tabs').show();});
	//jQuery(function(){jQuery('#opseosubmenu').tabs();jQuery('#opseosubmenu').show();});
	//jQuery(function(){jQuery('#misc-tabs').tabs();jQuery('#misc-tabs').show();});







	var opseoKeywordTabs = jQuery('#keyword-tabs li.keywordtabs');
	var opseoKeywordTabsContents = jQuery('.keywords-tabs-panel');

	jQuery(function(){
		opseoKeywordTabsContents.hide(); //hide all contents
		opseoKeywordTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoKeywordTabsContents[0]).show();
		jQuery(opseoKeywordTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoKeywordTabs.bind('click',function() {
		opseoKeywordTabsContents.hide(); //hide all contents
		opseoKeywordTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoKeywordTabsContents[jQuery('#keyword-tabs li.keywordtabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});



	var opseoSubmenuTabs = jQuery('#opseosubmenu li.opseosubmenutabs');
	var opseoSubmenuContents = jQuery('.opseosubmenu-panel');

	jQuery(function(){

		opseoSubmenuContents.hide(); //hide all contents
		opseoSubmenuTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoSubmenuContents[0]).show();
		jQuery(opseoSubmenuTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoSubmenuTabs.bind('click',function() {
		opseoSubmenuContents.hide(); //hide all contents
		opseoSubmenuTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoSubmenuContents[jQuery('#opseosubmenu li.opseosubmenutabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});



	var opseoSuggestionTabs = jQuery('#suggestion-tabs li.suggestiontabs');
	var opseoSuggestionContents = jQuery('.suggestion-tabs-panel');

	jQuery(function(){

		opseoSuggestionContents.hide(); //hide all contents
		opseoSuggestionTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoSuggestionContents[0]).show();
		jQuery(opseoSuggestionTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoSuggestionTabs.bind('click',function() {
		opseoSuggestionContents.hide(); //hide all contents
		opseoSuggestionTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoSuggestionContents[jQuery('#suggestion-tabs li.suggestiontabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});



	var opseoMiscTabs = jQuery('#misc-tabs li.misctabs');
	var opseoMiscContents = jQuery('.misc-tabs-panel');

	jQuery(function(){

		opseoMiscContents.hide(); //hide all contents
		opseoMiscTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoMiscContents[0]).show();
		jQuery(opseoMiscTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoMiscTabs.bind('click',function() {
		opseoMiscContents.hide(); //hide all contents
		opseoMiscTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoMiscContents[jQuery('#misc-tabs li.misctabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});




	<?php	if(!isset($this->postMeta['onpageseo_global_settings']['MainKeyword']) || (strlen(trim($this->postMeta['onpageseo_global_settings']['MainKeyword'])) == 0)){?>
		jQuery(function(){jQuery('#opseosubmenu').hide();});
	<?php }?>


	jQuery(function(){
		jQuery('#lsikeywordsloader').hide();
		jQuery('#lsi_keywords').hide();
		jQuery('.onpageseoerror').hide();
	});



	// Update Error Message
	jQuery(function(){

		var analyzeErrorMessage = '<?php echo get_option(OPSEO_PREFIX.'_error_message');?>';

		if(analyzeErrorMessage.length > 0)
		{
			jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> '+analyzeErrorMessage);
			jQuery('.onpageseoerror').show();
		}
	});



	jQuery(function(){jQuery(this).updateSecondaryKeywords();});

	jQuery(function(){

		jQuery('.onpageseoscoremetabox').show();
		jQuery('.onpageseoscore').show();
	});









jQuery.fn.replaceDroppableText = function(anchorText) {

	var selectedKeyword = '';
	var errorMsg = 0;


	// Main Keyword
	if(opseoMainTabSelected == 0)
	{
		if(jQuery.trim(jQuery('#mainkeyword').val()) == '')
		{
			jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Enter a primary keyword into the textbox.', OPSEO_TEXT_DOMAIN);?>');
			jQuery('.onpageseoerror').show();
			errorMsg = 1;
		}

		selectedKeyword = jQuery('#mainkeyword').val();
	}
	// Secondary Keyword
	else
	{
		if(jQuery.trim(jQuery('#secondarykeywords option:selected').val()) == '')
		{
			jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Select a keyword from the secondary keywords.', OPSEO_TEXT_DOMAIN);?>');
			jQuery('.onpageseoerror').show();
			errorMsg = 1;
		}

		selectedKeyword = jQuery('#secondarykeywords option:selected').text();
	}



	if(!errorMsg) {
		anchorText = anchorText.replace(/(<a[^>]+>).+(<\/a>)/i, "$1"+selectedKeyword+"$2");
		anchorText = anchorText.replace(/XqXsXvX/i, selectedKeyword);
		anchorText = anchorText.replace(/XqXsXvX/i, selectedKeyword);
	}
	else {
		anchorText = anchorText.replace(/XqXsXvX/i, '');
		anchorText = anchorText.replace(/XqXsXvX/i, '');
	}

	return(anchorText);

};


jQuery.fn.activateDroppables = function() {

	// Content Area (HTML Tab)
	jQuery('#content').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.html()); } });

	// Content Area (Visual Tab)
	if(typeof tinyMCE=='object') { jQuery('#content_ifr').droppable({ drop: function(event, ui) { tinyMCE.execCommand('mceInsertContent',false, jQuery(this).replaceDroppableText(ui.draggable.html()) ); } }); }
	//if(typeof tinyMCE=='object') { jQuery('#content_ifr').droppable({ drop: function(event, ui) { jQuery(this).tinymce.execCommand('mceInsertContent',false, jQuery(this).replaceDroppableText(ui.draggable.html()) ); } }); }else {alert('no tinymce');}

	// Main Keyword
	jQuery('#mainkeyword').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.text()); } });

	// Secondary Keyword
	jQuery('#secondary-keyword-add').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.text()); } });

	// Title
	jQuery('#title').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.text()); } });

	// Excerpt
	if(jQuery('#excerpt').length){jQuery('#excerpt').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.text()); } });}

	// Tag
	jQuery('#new-tag-post_tag').droppable({ drop: function(event, ui) { jQuery(this).insertAtCaret(ui.draggable.text()); } });

};


// Wait for iframe#content_ifr to Load
jQuery.fn.miscDragAndDrop = function(){

	// Internal Links
	jQuery('.draggableslinks').draggable({ iframeFix:true, revert:true, helper:'clone', start: function(event, ui) {jQuery(this).fadeTo('fast', 0.5);}, stop: function(event, ui) { jQuery(this).fadeTo(0, 1); } });

	// Internal Images
	jQuery('.draggablesimages').draggable({ iframeFix:true, revert:true, helper:'clone', start: function(event, ui) {jQuery(this).fadeTo('fast', 0.5);}, stop: function(event, ui) { jQuery(this).fadeTo(0, 1); } });

	// Activate Droppables
	jQuery(this).activateDroppables();

	jQuery('.draggableslinks a').click(function(){
		return false;
	});

	jQuery('.draggablesimages a').click(function(){
		return false;
	});

};






	// Display Keywords Button Clicked
	jQuery('#reload-lsi-keywords').click(function(){


		var wpEditorText = '';

		if(jQuery('#content_ifr').contents().find('#tinymce').html())
		{
			wpEditorText = jQuery('#content_ifr').contents().find('#tinymce').html();
		}
		else
		{
			wpEditorText = jQuery('#content').val();
		}

		var data = {
			action: 'onpageseo_lsi_keywords',
			content: wpEditorText
		};



		jQuery.post(ajaxurl, data, function(response) {

			if(response)
			{
				wpEditorText = response;

				var selectedKeyword = '';

				// Main Keyword
				if(opseoMainTabSelected == 0)
				{
					if(jQuery.trim(jQuery('#mainkeyword').val()) == '')
					{
						jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Enter a primary keyword into the textbox.', OPSEO_TEXT_DOMAIN);?>');
						jQuery('.onpageseoerror').show();
						return false;
					}

					selectedKeyword = jQuery('#mainkeyword').val();
				}
				// Secondary Keyword
				else
				{
					if(jQuery.trim(jQuery('#secondarykeywords option:selected').val()) == '')
					{
						jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Select a keyword from the secondary keywords.', OPSEO_TEXT_DOMAIN);?>');
						jQuery('.onpageseoerror').show();
						return false;
					}

					selectedKeyword = jQuery('#secondarykeywords option:selected').text();
				}

				jQuery('#lsi_keywords').empty();
				jQuery('#lsi_keywords').hide();
				jQuery('#lsikeywordsloader').show();


				var apikey = '6ED5887FEE16C463264AF9A869A64ACD43A601DF';
				var accountKey = 'gtjGWSu/QnCSeTO44UoMbDybitt57PRCg4J0B/OO8EM=';
				var kwAssoc = new Array();
				var lsiKeywords = new Array();
				var lsiSecondaryKeywords = new Array();
				var lsiKeywordDisplay = '';
				var lsiSecondaryKeywordDisplay = '';

				jQuery.ajax(
				{
					type: "GET",
					contentType: "application/json; charset=utf-8",
					scriptCharset: "utf-8",
					dataType: "jsonp",
					url: 'http://api.bing.net/json.aspx?AppId='+apikey+'&Version=2.2&Query='+encodeURIComponent(selectedKeyword)+'&Sources=RelatedSearch&JsonType=callback&JsonCallback=?',
					success: function(data){


https://api.datamarket.azure.com/Bing/SearchWeb?$top=50&AppId=gtjGWSu/QnCSeTO44UoMbDybitt57PRCg4J0B/OO8EM=&Query=%27marketing%27&Sources=RelatedSearch&JsonType=callback&JsonCallback=?



						// No Related Keywords - Display Error
						if(data['SearchResponse']['RelatedSearch'] === undefined)
						{
							this.error('<span>Error:</span> No relevant keywords found.');
						}
						// Related Searches Found
						else
						{
							lsiKeywords = data['SearchResponse']['RelatedSearch']['Results'];

							if(lsiKeywords.length > 0) lsiKeywordDisplay += '<ul id="sortable">';
							for (var i = 0; i < lsiKeywords.length; i++)
							{
								var highlight = ''

								if(wpEditorText.toLowerCase().indexOf(jQuery.trim(lsiKeywords[i].Title.toLowerCase())) >= 0)
								{
									highlight = ' lsihighlight';
								}

								lsiKeywordDisplay += '<li class="draggables'+highlight+'" id="lsikeyword'+i+'">' + lsiKeywords[i].Title + '</li>';
								if(i >= (<?php echo $this->options['lsi_keyword_maximum_results'];?> - 1)) break;
							}
							if(lsiKeywords.length > 0) lsiKeywordDisplay += lsiSecondaryKeywordDisplay + '</ul>';

							jQuery('#lsi_keywords').html(lsiKeywordDisplay);

							// LSI Keywords Draggable
							jQuery('.draggables').draggable({ iframeFix:true, revert:true, helper:'clone', start: function(event, ui) {jQuery(this).fadeTo('fast', 0.5);}, stop: function(event, ui) { jQuery(this).fadeTo(0, 1); } });

							// Activate Droppables
							jQuery(this).activateDroppables();

							jQuery('#lsikeywordsloader').hide();
							jQuery('#lsi_keywords').show();

						}

					},
					error: function(errorMsg){ jQuery('#lsikeywordsloader').hide(); jQuery('#lsi_keywords').hide(); jQuery('.onpageseoerror').html(errorMsg); jQuery('.onpageseoerror').show(); }

				}); // ajax() ends

			}

		});



	}); // click() ends


jQuery.fn.getSelectedSecondaryKeyword = function() {
	if(jQuery.trim(jQuery('#secondarykeywords option:selected').val()) != '')
	{
		return(jQuery('#secondarykeywords option:selected').text());
	}
	else
	{
		jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Select a keyword from the secondary keywords.', OPSEO_TEXT_DOMAIN);?>');
		jQuery('.onpageseoerror').show();
	}
};


jQuery.fn.deleteSecondaryKeyword = function() {

	if(jQuery.trim(jQuery('#secondarykeywords option:selected').val()) != '')
	{
		var answer = confirm('<?php _e('Are you sure you want to delete the keyword?', OPSEO_TEXT_DOMAIN);?>');
		if(answer) { jQuery('#secondarykeywords option:selected').remove(); }
		jQuery('.onpageseoerror').hide();
		jQuery(this).updateSecondaryKeywords();
		jQuery(this).toggleKeywordTabs(1);
	}
	else
	{
		jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Select a keyword from the secondary keywords.', OPSEO_TEXT_DOMAIN);?>');
		jQuery('.onpageseoerror').show();
	}

};


jQuery.fn.editSecondaryKeyword = function() {

	if(jQuery.trim(jQuery('#secondarykeywords option:selected').val()) != '')
	{
		if(jQuery.trim(jQuery('#secondary-keyword-add').val()) != '')
		{
			jQuery('#secondarykeywords option:selected').val(jQuery('#secondary-keyword-add').val());
			jQuery('#secondarykeywords option:selected').text(jQuery('#secondary-keyword-add').val());
			jQuery('#secondary-keyword-add').val('');
			jQuery('.onpageseoerror').hide();
			jQuery(this).updateSecondaryKeywords();
			jQuery(this).toggleKeywordTabs(1);
		}
		else
		{
		jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Enter a new value into the textbox.', OPSEO_TEXT_DOMAIN);?>');
		jQuery('.onpageseoerror').show();
		}
	}
	else
	{
		jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Select a keyword from the secondary keywords.', OPSEO_TEXT_DOMAIN);?>');
		jQuery('.onpageseoerror').show();
	} 

};



jQuery.fn.addSecondaryKeyword = function() {

	if(jQuery.trim(jQuery('#secondary-keyword-add').val()) != '')
	{
		jQuery('#secondarykeywords').append('<option value="'+jQuery('#secondary-keyword-add').val()+'" selected="selected">'+jQuery('#secondary-keyword-add').val()+'</option>');
		jQuery('#secondary-keyword-add').val('');
		jQuery('.onpageseoerror').hide();

		// Update Hidden Form Field
		jQuery(this).updateSecondaryKeywords();

		// Update Scores
		jQuery(this).toggleKeywordTabs(1);

	}
	else
	{
		jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> <?php _e('Type in a keyword into the textbox.', OPSEO_TEXT_DOMAIN);?>');
		jQuery('.onpageseoerror').show();
	}

};

jQuery.fn.clearSecondaryKeywords = function() {
	var answer = confirm('<?php _e('Are you sure you want to clear the secondary keywords?', OPSEO_TEXT_DOMAIN);?>');
	if(answer)
	{
		jQuery('#secondarykeywords').empty();
		jQuery('#allsecondarykeywords').val('');
		jQuery(this).toggleKeywordTabs(1);
	}

	jQuery('.onpageseoerror').hide();

};



jQuery.fn.getSelectedKeywordTab = function() {

	return(jQuery('#keyword-tabs').tabs().tabs('option', 'selected'));

};

jQuery.fn.opseoDisplayErrorMesage = function(errorMsg) {
	jQuery('.onpageseoerror').html('<span><?php _e('Error:', OPSEO_TEXT_DOMAIN);?></span> ' + errorMsg);
	jQuery('.onpageseoerror').show();
};



jQuery.fn.insertAtCaret = function (myValue) {

	myValue = jQuery(this).replaceDroppableText(myValue);

	return this.each(function(){
			//IE support
			if (document.selection) {
					this.focus();
					sel = document.selection.createRange();
					sel.text = myValue;
					this.focus();
			}
			//MOZILLA / NETSCAPE support
			else if (this.selectionStart || this.selectionStart == '0') {
					var startPos = this.selectionStart;
					var endPos = this.selectionEnd;
					var scrollTop = this.scrollTop;
					this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
					this.focus();
					this.selectionStart = startPos + myValue.length;
					this.selectionEnd = startPos + myValue.length;
					this.scrollTop = scrollTop;
			} else {
					this.value += myValue;
					this.focus();
			}
	});
};




}); // ready() ends


</script>


			</div>

<?php
	// Delete Analyze URL Error Message (4-5-2012)
	delete_option(OPSEO_PREFIX.'_error_message', '');
?>