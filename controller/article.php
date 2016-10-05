<?
$id = (int)$_GET['id'];
$m_article = strong::loadModel("articles");
$article = $m_article->getArticle(array('id'=>$id));
?>