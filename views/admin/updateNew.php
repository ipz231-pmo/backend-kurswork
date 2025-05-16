<?php
/**
 * @var array $item
 */
?>

<div>
    <div class="container">
        <form action="/admin/readNews" method="post">
            <input type="hidden" name="id" value="<?= $item['id'] ?>" />
            <table>
                <tr>
                    <td>Id</td>
                    <td><?= $item['id'] ?></td>
                </tr>
                <tr>
                    <td><label for="title">Title</label></td>
                    <td><input type="text" name="title" id="title" value="<?= $item['title'] ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
