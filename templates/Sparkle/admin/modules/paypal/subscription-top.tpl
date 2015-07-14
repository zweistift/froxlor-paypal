$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" /> 
				{$lng['modules']['paypal']['subs']}
			</h2>
		</header>

		<section>
<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'subscription', 'page' => $page, 'action' => 'add'))}">{$lng['plugin']['paypal']['addabo']}</a>
				</div>
<table class="full hl">
<th>$lng['modules']['paypal']['subsid']</th><th>$lng['modules']['paypal']['subscode']</th><th>$lng['modules']['paypal']['subsdesc']</th><th>$lng['modules']['paypal']['subscostm']</th><th>$lng['modules']['paypal']['subscosty']</th><th>$lng['modules']['paypal']['options']</th>

