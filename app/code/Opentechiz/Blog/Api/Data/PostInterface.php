<?php
namespace Opentechiz\Blog\Api\Data;

interface PostInterface
{
   const POST_ID = "post_id";
   const URL_KEY = "url_key";
   const TITLE = "title";
   const CONTENT = "content";
   const CREATION_TIME = "creation_time";
   const UPDATE_TIME = "update_time";
   const IS_ACTIVE = "is_active";

   public function getId();
   
   public function setId($id);

   public function getUrlKey();
   
   public function setUrlKey($url_key);

   public function getTitle();
   
   public function setTitle($title);

   public function getContent();
   
   public function setContent($content);

   public function getCreationTime();
   
   public function setCreationTime($creationTime);

   public function getUpdateTime();
   
   public function setUpdateTime($updateTime);

   public function isActive();
   
   public function setIsActive($isActive);

}