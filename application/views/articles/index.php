<h3>All news</h3>
<table>
{articles}
    <tr>
        <td>{date}</td>
        <td>{title_es}</td>
        <td>{content_es}</td>
        <td>{title_en}</td>
        <td>{content_en}</td>
        <td>{main_pic}</td>
        <td><a href="<?php echo site_url('articles/view'); ?>/{slug_es}">view</a></td>
    </tr>
{/articles}
</table>
