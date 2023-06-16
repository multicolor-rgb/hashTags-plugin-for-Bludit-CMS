<?php

class hashTags extends Plugin
{



	public function form()
	{
		// Token for send forms in Bludit
		global $security;
		$tokenCSRF = $security->getTokenCSRF();

		// Current site title
		global $site;
		$title = $site->title();

		// HTML code for the form
		$html = '

		<h3>How to use it?</h3>
<p class="text-muted">This plugin generate hashtag with link to tags inside content</p>

<hr>

<div class="col-md-12 border p-3">
<p class="lead">If you want create link with hashtags in content use shortcode like this example</p>

<code>[ #=tagname ] like [ #=lorem ipsum dolor ]</code>

<p class="lead mt-3">If you want only link without hashtag symbol use shortcode like this example</p>

<code>[ !#=tagname ] like [ !#=lorem ipsum dolor ]</code></code>
</div>


<div class="bg-light text-center border mt-3 p-3">
 
	<p class="mb-2"> If you like use my plugin! Buy me ☕ </p>
	
	<a href="https://www.paypal.com/donate/?hosted_button_id=UCKEMTCPCKGHE" target="_blank">
	<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" />
 </a>
</div>
		';
		return $html;
	}



	public function pageBegin()
	{

		global $page;

		$newcontentHash = preg_replace_callback(
			'/(\\[\s\\#\\=)([a-zA-Z0-9\s]+)(\s\\])/i',
			"hashShow",
			$page->content()
		);


		$noHashAdded = preg_replace_callback(
			'/(\\[\s\\!\\#\\=)([a-zA-Z0-9\s]+)(\s\\])/i',
			"noHashShow",
			$newcontentHash
		);



		global $page;
		$page->setField('content', $noHashAdded);
	}


	public function siteHead()
	{

		function hashShow($matches)
		{

			return '<a href="' . DOMAIN_TAGS . str_replace(' ', '-', $matches[2]) . '">#' . $matches[2] . '</a>';
		};

		function noHashShow($matches)
		{


			return '<a href="' . DOMAIN_TAGS . str_replace(' ', '-', $matches[2]) . '">' . $matches[2] . '</a>';
		};
	}
}
