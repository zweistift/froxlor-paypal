$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="abos anlegen" />&nbsp;
$lng['modules']['paypal']['subadd']			</h2>
		</header>

		<section>
			<form action="{$linker->getLink(array('section' => 'billing', 'page' => 'abos', 'action' => 'insert', 'state' => 'save', 'id' => $id))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />
				<input type="hidden" name="id" value="$id" />
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

