<?php

include_once 'CurlService.php';
include_once 'SearchResponse.php';

/**
 * This class/service handles all library functionalities
 */
class LibraryService
{
    public function searchBook()
    {
        $searchResponse = new SearchResponse();
        $searchResponse->success = false;

        $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : null;

        try {
            if ($isbn) {
                //search book by isbn
                $url = "https://openlibrary.org/isbn/{$isbn}.json";
                $result = CurlService::request($url);

                if ($result === 'Not Found') {
                    $searchResponse->message = $result;
                    return $searchResponse;
                }

                $searchResponse->success = true;
                $searchResponse->bookTitle = $result->title;
                $searchResponse->publishDate = isset($result->publish_date) ? $result->publish_date : null;

                //getting author info
                $authorKey = count($result->authors) > 0 ? $result->authors[0]->key : null;
                $authorKey = str_replace('/authors/', '', $authorKey);
                $author = $this->searchAuthor($authorKey);
                $searchResponse->authorName = $author->name;
                $searchResponse->authorBiography = isset($author->bio) ? $author->bio->value : null;

                //getting author works
                $searchResponse->works = [];
                $authorWorks = $this->searchAuthorWorks($authorKey, 4);
                if (isset($authorWorks->entries) && count($authorWorks->entries) > 1) {
                    foreach ($authorWorks->entries as $work ) {
                        if (count($searchResponse->works) < 3 && $work->title !== $searchResponse->bookTitle) {
                            $searchResponse->works[] = $work->title;
                        }
                    }
                }

                return $searchResponse;
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            $searchResponse->message = $exception->getMessage();
        }

        return $searchResponse;
    }

    public function searchAuthor($authorKey)
    {
        $result = null;

        try {
            $url = "https://openlibrary.org/authors/{$authorKey}.json";
            $result = CurlService::request($url);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

        return  $result;
    }

    public function searchAuthorWorks($authorKey, $limit = 3)
    {
        $result = null;

        try {
            $url = "https://openlibrary.org/authors/{$authorKey}/works.json?limit=$limit";
            $result = CurlService::request($url);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

        return  $result;
    }
}