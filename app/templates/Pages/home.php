<?= $this->Form->create() ?>
<?= $this->Form->end() ?>

<script>
window.addEventListener("DOMContentLoaded", async (event) => {
  const response = await fetch("<?= $this->Url->build([
    'prefix' => 'Api',
    'controller' => 'Users',
    'action' => 'create',
    '_ext' => 'json',
  ]) ?>", {
    method: "post",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "<?= $this->request->getCookie('csrfToken') ?>",
    },
    body: JSON.stringify({
      name: "John Doe",
    }),
  });

  const responseData = await response.json();

  console.log({ responseData });
});
</script>

