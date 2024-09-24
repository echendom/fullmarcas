<?php
/**
 * Created by PhpStorm.
 * User: enrico
 * Date: 06-05-20
 * Time: 17:48.
 */

 namespace App\Services;

use App\Models\Post;

class PaginateService
{
    // ATTRIBUTES //
    private $postType = false;
    private $page = 1;
    private $ppp = -1;
    private $order = '';
    private $sort = '';
    private $search = '';
    private $filterTaxonomyId = false;
    private $relationFilterTaxonomy = '';
    private $meta_date_key = 'date';
    private $date_arr = false;
    private $date_event = false;
    private $order_meta = false;
    private $filterCategory = false;
    private $taxonomyFilter = false;
    private $orderFilter = false;

    private $meta_query = false;
    private $meta_query_compare = '';
    private $meta_filter = false;
    private $meta_query_type = '';
    private $meta_query_key = '';
    private $meta_query_value = '';

    // SETTERS/GETTERS //

    public function __construct($postType = false)
    {
        $this->post_type = $postType;
    }

    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    public function setPpp($ppp)
    {
        $this->ppp = (int) $ppp;

        return $this;
    }

    public function setOrderBy($order, $sort)
    {
        $this->order = $order;
        $this->sort = $sort;

        return $this;
    }

    public function setOrderByMeta($order_meta = false)
    {
        $this->order_meta = $order_meta;

        return $this;
    }

    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    public function setFilterByTaxonomyId($arr, $relation = '')
    {
        $this->relationFilterTaxonomy = $relation; //OR AND, DEFAULT AND

        $this->filterTaxonomyId = $arr;

        return $this;
    }

    public function setDateString($arr, $date_event = false)
    {
        $this->date_arr = $arr;
        $this->date_event = $date_event;

        return $this;
    }

    public function setDate($arr)
    {
        $this->date_arr = $arr;

        return $this;
    }

    public function setMetaDateKey($meta_date_key = '')
    {
        $this->meta_date_key = $meta_date_key;

        return $this;
    }

    public function setTaxonomyOrder($taxonomy, $order = 'DESC'){

        $this->taxonomyFilter = $taxonomy;
        $this->orderFilter = $order;

        return $this;
    }

    public function setMetaQuery($meta, $compare = '=', $type = false)
    {
        $this->meta_query = true;
        $this->meta_query_key = $meta;
        $this->meta_query_compare = $compare;
        $this->meta_query_value = $type;

        return $this;
    }

    public function setMetaFilter($meta_filter = [])
    {
        $this->meta_filter = $meta_filter;

        return $this;
    }

    public function get()
    {
        $posts = new Post($this->post_type);
        $posts = $this->search($posts);
        $posts = $this->orderBy($posts);
        $posts = $this->inTerm($posts);
        if($this->taxonomyFilter != false){
            $posts = $this->orderTaxonomy($posts);
        }

        if ($this->date_arr != false) {
            if ($this->date_event) {
                $posts = $this->courseDatesQuery($posts);
            } else {
                $posts = $this->dateQuery($posts);
            }
        }

        if($this->meta_filter != false){
            $posts = $posts->customQuery('meta_query', $this->meta_filter);
        }

        if ($this->meta_query != false) {
            $posts = $posts->withMetaQuery($this->meta_query_key, $this->meta_query_compare, $this->meta_query_value);
        }

        $result = $this->paginate($posts);

        return $result;
    }

    private function paginate($posts)
    {
        $posts = $posts->withPagination($this->page)->postsPerPage($this->ppp)->get();
        $result['pagination']['current_page'] = $this->page;
        $result['pagination']['next_page'] = $this->page >= $posts->max_num_pages ? false : $this->page + 1;
        $result['pagination']['total_items'] = $posts->found_posts;
        // $result['pagination']['quantity'] = count($posts->get_posts());
        $result['pagination']['per_page'] = count($posts->posts);
        if ($result['pagination']['per_page']) {
            $result['pagination']['max_pages'] = ceil((int) $result['pagination']['total_items'] / $this->ppp);
        } else {
            $result['pagination']['max_pages'] = 0;
        }
        
        // $result['pagination']['posts'] = $posts->get_posts();
        $result['data']['posts'] = $posts->posts;
        
        return $result;
    }

    private function orderBy($posts)
    {
        if ($this->order_meta) {
            $posts = $posts->orderByMeta($this->order_meta['meta_key'],$this->order_meta['order'] , $this->order_meta['orderby']);
        } elseif ($this->order != '' && $this->sort != '') {
            $posts = $posts->orderBy($this->sort, $this->order);
        }

        return $posts;
    }

    private function search($posts)
    {
        if ($this->search != '') {
            $posts = $posts->search($this->search);
        }

        return $posts;
    }

    private function inTerm($posts)
    {
        if ($this->filterTaxonomyId != false) {
            if (is_array($this->filterTaxonomyId)) {
                // foreach ($this->filterTaxonomyId as $item) {
                    $posts = $posts->inTerms($this->filterTaxonomyId, $this->relationFilterTaxonomy);
                // }
            } else {
                $posts = $posts->inTerm($this->filterTaxonomyId);
            }
        }
        return $posts;
    }

    private function orderTaxonomy($posts){
        $posts = $posts->orderByTaxonomy($this->taxonomyFilter, $this->orderFilter);
        return $posts;
    }

    private function dateQuery($post)
    {
        $post = $post->customQuery('date_query', $this->date_arr);

        return $post;
    }

    private function courseDatesQuery($post)
    {
        $post = $post->withMetaQuery([
            'key' => $this->meta_date_key,
            'value' => $this->date_arr,
        ], 'BETWEEN', 'DATE');
        
        return $post;
    }

    private function metasQueries($post){

        $post = $post->customQuery('meta_query', $this->meta_filter);

        return $post;
    }



}
