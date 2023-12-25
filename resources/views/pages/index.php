<?= view('layouts/root.start') ?>
<?= view('partials/nav') ?>
<?= view('partials/banner', ['heading' => 'Home']) ?>


<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>. Welcome to the home page.</p>
    </div>

    {{"hello world"}}
</main>


<?= view('layouts/root.end') ?>