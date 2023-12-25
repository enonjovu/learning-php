<?= view('layouts/root.start') ?>
<?= view('partials/nav') ?>
<?= view('partials/banner', ['heading' => 'Notes']) ?>


<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <ul class="border divide-y rounded-md w-full max-w-md">
            <?php foreach ($notes as $note) : ?>
                <li class="max-w-md flex items-center justify-between p-2">
                    <a href="/notes/<?= $note['id'] ?>" class="text-blue-500 hover:underline">
                        <?= htmlspecialchars($note['body']) ?>
                    </a>
                    <div class="flex space-x-4">

                        <a href="/notes/<?= $note['id'] ?>/edit"
                            class="px-3 py-2 rounded-md bg-yellow-600 text-white">edit</a>

                        <form action="/notes/<?= $note['id'] ?>" method="POST">
                            <input type="hidden" value="DELETE" name="_method" />
                            <button class="px-3 py-2 rounded-md bg-red-600 text-white">delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <p class="mt-6">
            <a href="/notes/create" class="text-blue-500 hover:underline">Create Note</a>
        </p>
    </div>
</main>

<?= view('layouts/root.end') ?>