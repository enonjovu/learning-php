<?= view('layouts/root.start') ?>
<?= view('partials/nav') ?>
<?= view('partials/banner', ['heading' => 'About']) ?>


<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello. Welcome to the about page.</p>
    </div>
</main>


<?= view('layouts/root.end') ?>