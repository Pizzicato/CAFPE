<h3>All news</h3>
<table>
{articles}
    <tr>
        <td>{date}</td>
        <td>{title}</td>
        <td>{content}</td>
        <td>{main_pic}</td>
        <td><a href="<?php echo site_url('article/'); ?>{slug}">view</a></td>
    </tr>
{/articles}
</table>
