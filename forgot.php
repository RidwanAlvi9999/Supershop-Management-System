
<h3>Forgot Password</h3>
<?= isset($msg)?$msg:'' ?>
<form method="post">
<input name="email" type="email" required placeholder="Email"><br>
<button>Send Token</button>
</form>
