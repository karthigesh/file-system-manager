<?php
// Generates file include tags
function include_files($file = array(), $place = 'header')
{
	
	if ( ! isset($file['css']) && ! isset($file['js']) && ! isset($file['pre_defined']))
	{
		return FALSE;
	}
	
	// Get priority level
	$priority = ( ! isset($file['priority'])) ? 'low' : $file['priority'];
	
	// Do avoid double time including file(s)
	if (($place == 'header' && $priority == 'low') OR ($place == 'footer' && $priority == 'high'))
	{
		return FALSE;
	}
	
	// Get base URL
	$base_url = BASE_URL;
	
	global $pre_defined_files;
	
	$str = '';
	if ( ! empty($file['css']))
	{
		foreach ($file['css'] as $item)
		{
			$href = (preg_match('/\b(http|https)\b/', $item) OR strpos($item, '//') !== FALSE) ? $item : $base_url . $item;
			$str .= '<link rel="stylesheet" href="'. $href .'" type="text/css" />'."\n";
		}
	}
	
	if ( ! empty($file['pre_defined']))
	{
		foreach ($file['pre_defined'] as $item)
		{
			if (isset($pre_defined_files[$item]) && isset($pre_defined_files[$item]['css']))
			{
				foreach ($pre_defined_files[$item]['css'] as $item)
				{
					$href = (preg_match('/\b(http|https)\b/', $item) OR strpos($item, '//') !== FALSE) ? $item : $base_url . $item;
					$str .= '<link rel="stylesheet" href="'. $href .'" type="text/css" />'."\n";
				}
			}
		}
	}
	
	if ( ! empty($file['js']))
	{
		foreach ($file['js'] as $item)
		{
			$href = (preg_match('/\b(http|https)\b/', $item) OR strpos($item, '//') !== FALSE) ? $item : $base_url . $item;
			$str .= '<script type="text/javascript" src="'. $href .'"></script>'."\n";
		}
	}
	
	if ( ! empty($file['pre_defined']))
	{
		foreach ($file['pre_defined'] as $item)
		{
			if (isset($pre_defined_files[$item]) && isset($pre_defined_files[$item]['js']))
			{
				foreach ($pre_defined_files[$item]['js'] as $item)
				{
					$href = (preg_match('/\b(http|https)\b/', $item) OR strpos($item, '//') !== FALSE) ? $item : $base_url . $item;
					$str .= '<script type="text/javascript" src="'. $href .'"></script>'."\n";
				}
			}
		}
	}
	
	return $str;
}
?>
