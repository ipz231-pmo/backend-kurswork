<?php

/**
 * @var array $items
 */

$this->title = 'News Editor';


?>

<div>
    <div class="container">
        <table>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Short Text</th>
                <th>Text</th>
                <th>Date</th>
            </tr>
            
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['title'] ?></td>
                <td><?= $item['shortText'] ?></td>
                <td><?= $item['text'] ?></td>
                <td><?= $item['date'] ?></td>
                <td>
                    <a href="/admin/deleteNew?id=<?= $item['id'] ?>">Delete</a>
                    <a href="/admin/updateNew?id=<?= $item['id'] ?>">Update</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
        </table>
    </div>
</div>
