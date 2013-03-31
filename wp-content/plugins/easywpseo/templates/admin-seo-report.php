<?php
		// Post Meta Data Already Exists

				global $post;

				$lcMainKeyword = strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword']);

					echo '<style>

						.opseo-report-h1
						{
							color: #0972a9 !important;
							margin: 10px 0 30px 0 !important;
						}

						.opseo-report-h2
						{
							color: #03486e !important;
							margin: 0 0 20px 0 !important;
						}

						.opseo-report-h2-margin
						{
							color: #03486e !important;
							margin: 20px 0 !important;
						}

						.opseo-report-h3
						{
							color: #03486e !important;
							margin: 0 0 10px 0 !important;
							padding-bottom: 0 0 3px 0 !important;
							border-bottom: 1px solid rgb(3,72,110);
						}

						.opseo-report-p
						{
							margin: 0 0 10px 0 !important;
							padding: 0 0 5px 0 !important;
						}

						.opseo-report-p-margin
						{
							margin: 0 0 20px 0 !important;
							padding: 0 0 5px 0 !important;
						}

						.opseo-report-p-last
						{
							margin: 0 0 30px 0 !important;
							padding: 0 0 5px 0 !important;
						}

					</style>';

					echo '<h1 class="opseo-report-h1">'.__('On-Page SEO Report', OPSEO_TEXT_DOMAIN).'</h1>

					<h2 class="opseo-report-h2">'.__('Post/Page Information', OPSEO_TEXT_DOMAIN).'</h2>

					<h3 class="opseo-report-h3">'.__('Permalink', OPSEO_TEXT_DOMAIN).'</h3>';

					global $pagenow;
					$permalink = '';

					// URL Analyzer
					if($type == 2) { $permalink = $opseoURL; }
					// Post or Page
					else { $permalink = get_permalink($this->postID); }

					// URL Decode (9-20-11)
					$permalink = urldecode($permalink);

					echo '<p class="opseo-report-p-margin"><a href="'.$permalink.'">'.$permalink.'</a></p>

					<h3 class="opseo-report-h3">'.__('Title Tag', OPSEO_TEXT_DOMAIN).'</h3>';

					echo '<p class="opseo-report-p-margin">';
					for($iG = 0; $iG < sizeof($this->seoReport['Title']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['Title'][$iG].' (<i>'.strlen(utf8_decode($this->seoReport['Title'][$iG])).' characters</i>)';
					}
					echo '</p>';

					echo '<h3 class="opseo-report-h3">'.__('Meta Tags', OPSEO_TEXT_DOMAIN).'</h3>


					<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 !important;padding:0 !important;width:100%;">
					<tr>
					<td valign="top" style="width:90px;"><p class="opseo-report-p"><b>'.__('Description:', OPSEO_TEXT_DOMAIN).'</b></p></td>
					<td valign="top"><p class="opseo-report-p">';

					for($iG = 0; $iG < sizeof($this->seoReport['DescriptionMetaTag']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['DescriptionMetaTag'][$iG].' (<i>'.strlen(utf8_decode($this->seoReport['DescriptionMetaTag'][$iG])).' '.__('characters', OPSEO_TEXT_DOMAIN).'</i>)';
					}

					echo '</p></td></tr></table>



					<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 !important;padding:0 !important;">
					<tr>
					<td valign="top" style="width:90px;"><p class="opseo-report-p"><b>'.__('Keywords:', OPSEO_TEXT_DOMAIN).'</b></p></td>
					<td valign="top"><p class="opseo-report-p-margin">';

					for($iG = 0; $iG < sizeof($this->seoReport['KeywordsMetaTag']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['KeywordsMetaTag'][$iG].'<br />';
					}

					echo '</p></td></tr></table>




					<h3 class="opseo-report-h3">'.__('Heading Tags', OPSEO_TEXT_DOMAIN).'</h3>

					<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 !important;padding:0 !important;">
					<tr>
					<td valign="top" style="width:35px;"><p class="opseo-report-p"><b>'.__('H1:', OPSEO_TEXT_DOMAIN).'</b></p></td>
					<td valign="top"><p class="opseo-report-p">';

					for($iG = 0; $iG < sizeof($this->seoReport['H1']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['H1'][$iG] . '<br />';
					}

					echo '</p></td></tr></table>

					<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 !important;padding:0 !important;">
					<tr>
					<td valign="top" style="width:35px;"><p class="opseo-report-p"><b>'.__('H2:', OPSEO_TEXT_DOMAIN).'</b></p></td>
					<td valign="top"><p class="opseo-report-p">';

					for($iG = 0; $iG < sizeof($this->seoReport['H2']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['H2'][$iG] . '<br />';
					}

					echo '</p></td></tr></table>

					<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 !important;padding:0 !important;">
					<tr>
					<td valign="top" style="width:35px;"><p class="opseo-report-p"><b>'.__('H3:', OPSEO_TEXT_DOMAIN).'</b></p></td>
					<td valign="top"><p class="opseo-report-p-margin">';

					for($iG = 0; $iG < sizeof($this->seoReport['H3']); $iG++)
					{
						echo '&bull;&nbsp;'.$this->seoReport['H3'][$iG] . '<br />';
					}

					echo '</p></td></tr></table>

					<h3 class="opseo-report-h3">'.__('Content', OPSEO_TEXT_DOMAIN).'</h3>';

					// Post or Page
					//if($type == 1)
					//{
					//	echo '<p class="opseo-report-p"><b>Post/Page Title:</b> '.$post->post_title.' (<i>'.strlen($post->post_title).' characters</i>)</p>';
					//}

					echo '<p class="opseo-report-p"><b>'.__('First 100 Words:', OPSEO_TEXT_DOMAIN).'</b> '.$this->seoReport['First100Words'].'</p>

					<p class="opseo-report-p-last"><b>'.__('Last 100 Words:', OPSEO_TEXT_DOMAIN).'</b> '.$this->seoReport['Last100Words'].'</p>

					<h2 class="opseo-report-h2">'.__('Readability', OPSEO_TEXT_DOMAIN).'</h2>';

					$gradeAverage = (int)(($this->postMeta['onpageseo_global_settings']['FleschGradeLevel'] + $this->postMeta['onpageseo_global_settings']['GunningFogScore'] + $this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'] + $this->postMeta['onpageseo_global_settings']['SMOGIndex'] + $this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex']) /  5);

					$ageGroup = '';
					if($gradeAverage < 1) { $ageGroup = __('under', OPSEO_TEXT_DOMAIN).' 6'; }
					elseif($gradeAverage == 1) { $ageGroup = '6 '.__('to', OPSEO_TEXT_DOMAIN).' 7'; }
					elseif($gradeAverage == 2) { $ageGroup = '7 '.__('to', OPSEO_TEXT_DOMAIN).' 8'; }
					elseif($gradeAverage == 3) { $ageGroup = '8 '.__('to', OPSEO_TEXT_DOMAIN).' 9'; }
					elseif($gradeAverage == 4) { $ageGroup = '9 '.__('to', OPSEO_TEXT_DOMAIN).' 10'; }
					elseif($gradeAverage == 5) { $ageGroup = '10 '.__('to', OPSEO_TEXT_DOMAIN).' 11'; }
					elseif($gradeAverage == 6) { $ageGroup = '11 '.__('to', OPSEO_TEXT_DOMAIN).' 12'; }
					elseif($gradeAverage == 7) { $ageGroup = '12 '.__('to', OPSEO_TEXT_DOMAIN).' 13'; }
					elseif($gradeAverage == 8) { $ageGroup = '13 '.__('to', OPSEO_TEXT_DOMAIN).' 14'; }
					elseif($gradeAverage == 9) { $ageGroup = '14 '.__('to', OPSEO_TEXT_DOMAIN).' 15'; }
					elseif($gradeAverage == 10) { $ageGroup = '15 '.__('to', OPSEO_TEXT_DOMAIN).' 16'; }
					elseif($gradeAverage == 11) { $ageGroup = '16 '.__('to', OPSEO_TEXT_DOMAIN).' 17'; }
					elseif($gradeAverage == 12) { $ageGroup = '17 '.__('to', OPSEO_TEXT_DOMAIN).' 18'; }
					else { $ageGroup = __('over', OPSEO_TEXT_DOMAIN).' 18'; }

					echo '<h3 class="opseo-report-h3">'.__('Analysis', OPSEO_TEXT_DOMAIN).'</h3>';

					echo '<p class="opseo-report-p-margin">'.sprintf(__('This content is %s with an average grade level of %s and should be understood by %s year olds.', OPSEO_TEXT_DOMAIN), strtolower($this->postMeta['onpageseo_global_settings']['FleschLevel']), $gradeAverage, $ageGroup).'</p>';


					echo '<h3 class="opseo-report-h3">Statistics</h3>';

					echo '<p class="opseo-report-p-margin">&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['SentenceCount'].' '.__('sentences', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['WordCount'].' '.__('words', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['AverageWordsPerSentence'].' '.__('words per sentence', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['AverageSyllablesPerWord'].' '.__('syllables per word', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['ComplexWordsNumber'].' '.__('complex words (3+ syllables)', OPSEO_TEXT_DOMAIN).'<br />&bull;&nbsp;'.$this->postMeta['onpageseo_global_settings']['ComplexWordsPercentage'].'% '.__('of words are complex', OPSEO_TEXT_DOMAIN).'</p>';

					echo '<h3 class="opseo-report-h3">'.__('Readability Scores', OPSEO_TEXT_DOMAIN).'</h3>';

					echo '<p class="opseo-report-p"><b>'.__('Flesch-Kincaid Reading Ease:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['FleschEase'].'</p>

					<p class="opseo-report-p"><b>'.__('Flesch-Kincaid Grade Level:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['FleschGradeLevel'].'</p>

					<p class="opseo-report-p"><b>'.__('Gunning-Fog Score:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['GunningFogScore'].'</p>

					<p class="opseo-report-p"><b>'.__('Coleman-Liau Index:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'].'</p>

					<p class="opseo-report-p"><b>'.__('SMOG Index:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['SMOGIndex'].'</p>

					<p class="opseo-report-p-last"><b>'.__('Automated Readability Index:', OPSEO_TEXT_DOMAIN).'</b> '.$this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex'].'</p>';


					// Primary Keyword
					$primaryKW = ($this->strExists($this->options['stop_words_enabled'])) ? $this->removeStopWords($this->postMeta['onpageseo_global_settings']['MainKeyword']) : $this->postMeta['onpageseo_global_settings']['MainKeyword'];
					echo '<h2 class="opseo-report-h2-margin">'.__('Primary Keyword', OPSEO_TEXT_DOMAIN).' &mdash; <i>'.$primaryKW.'</i></h2>';
					$this->displaySEOKeywordReport($lcMainKeyword);

					// Secondary Keywords

					foreach($this->postMeta as $key=>$val)
					{
						if(($key != 'onpageseo_global_settings') && ($key != $lcMainKeyword))
						{
							$secondaryKW = ($this->strExists($this->options['stop_words_enabled'])) ? $this->removeStopWords($this->postMeta[$key]['Keyword']) : $this->postMeta[$key]['Keyword'];
							echo '<h2 class="opseo-report-h2-margin">'.__('Secondary Keyword', OPSEO_TEXT_DOMAIN).' &mdash; <i>'.$this->postMeta[$key]['Keyword'].'</i></h2>';
							$this->displaySEOKeywordReport($key);
						}
					}

?>
