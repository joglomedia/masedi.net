<?php

	$this->adminHeader('onpageseo-url-analyzer', __('URL Analyzer', OPSEO_TEXT_DOMAIN));

	if(isset($_REQUEST['nonpost-action']))
	{
		switch($_REQUEST['nonpost-action'])
		{
			case 'add':
				// Insert URL
				if(isset($_REQUEST['updated']))
				{
					// Get URL Meta Data
					$this->saveMetaDataURL($_REQUEST['nonpost-url']);

					// Insert URL
					$this->addNonPostURL();
					include_once('admin-non-post-manage.php');
				}
				else
				{
					include_once('admin-non-post-add.php');
				}

				break;

			case 'edit':
				if(isset($_REQUEST['id']) && (strlen(trim($_REQUEST['id'])) > 0) && $this->checkNonPostURL($_REQUEST['id']) )
				{
					// Update URL
					if(isset($_REQUEST['updated']))
					{
						// Get URL Meta Data
						$this->saveMetaDataURL($_REQUEST['nonpost-url']);

						// Update URL
						$this->editNonPostURL($_REQUEST['id']);
					}
					// Get URL Info
					else
					{
						$this->getNonPostURL($_REQUEST['id']);
					}

					include_once('admin-non-post-edit.php');
				}
				else
				{
					include_once('admin-non-post-manage.php');
				}

				break;

			case 'delete':
				if(isset($_REQUEST['id']) && (strlen(trim($_REQUEST['id'])) > 0) && $this->checkNonPostURL($_REQUEST['id']) )
				{
					$this->deleteNonPostURL($_REQUEST['id']);
				}

				include_once('admin-non-post-manage.php');

				break;

			default:
				include_once('admin-non-post-manage.php');
				break;
		}
	}
	else
	{
		include_once('admin-non-post-manage.php');
	}

?>