<?php
namespace Opentechiz\Blog\Api\Data;

interface CommentInterface
{
    const COMMENT_ID    = 'comment_id';
    const POST_ID       = 'post_id';
    const TITLE         = 'title';
    const DETAIL        = 'detail';
    const NICKNAME      = 'nickname';
    const CUSTOMER_ID   = 'customer_id';
    const IS_ACTIVE     = 'is_active';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';

    public function getPostId();

    public function getCommentId();

    public function getTitle();

    public function getDetail();

    public function getNickName();

    public function getCustomerId();

    public function getCreationTime();

    public function getUpdateTime();

    public function isActive();

    public function setPostId($postId);

    public function setCommentId($commentId);

    public function setTitle($title);

    public function setDetail($detail);

    public function setNickName($nickName);

    public function setCustomerId($customerId);

    public function setCreationTime($creationTime);

    public function setUpdateTime($update);

    public function setIsActive($isActive);
}