$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/group_edit_big.png" alt="" /> 
				{$lng['plugin']['paypal']['abos']}
			</h2>
		</header>

		<section>
<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'subscription', 'page' => $page, 'action' => 'add'))}">{$lng['plugin']['paypal']['addabo']}</a>
				</div>
<table class="full hl">
<th>ABO ID</th><th>ABO CODE</th><th>ABO DESCRIPTION</th><th>ABO COSTS MONTH</th><th>ABO COSTS YEAR</th><th>Optionen</th>

