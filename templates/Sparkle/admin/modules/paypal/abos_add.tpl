$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="abos anlegen" />&nbsp;
				Abos anlegen
			</h2>
		</header>

		<section>
			<form action="{$linker->getLink(array('section' => 'billing', 'page' => 'abos', 'action' => 'insert'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />
				
				<table class="full">
                    {$customer_add_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section>
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}
			</p>
		</section>
	</article>

