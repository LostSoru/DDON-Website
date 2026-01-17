<?php


class News {
	
	public $no_data;
	public $news_title;
	public $news_content;
	public $news_type;
	public $news_poster;
	public $news_date;
	public $news_data;
	
	public function Load_Featured_News() {
		global $site_logging;
		
		try {
			$load_featured_news_sql = "SELECT * FROM ddon_news ORDER BY news_id DESC";
			$load_featured_news_params = NULL;
			$load_featured_news = new Database;
			$load_featured_news->query_data($load_featured_news_sql, $load_featured_news_params, "no", "select_data");
			$row = $load_featured_news->fetch_row;
			
			if($row) {
				$this->news_title = $row['news_title'];
				$this->news_type = $row['news_type'];
				$this->news_content = $row['news_content'];
				$this->news_poster = $row['news_poster'];
				$this->news_date = $row['news_date'];
			} else {
				$this->no_data = "Yes";
			}
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			//die();
		}
	}
	
	public function Load_News($limit) {
		$limit = (int)$limit;
		
		try {
			$load_news_sql = "SELECT *
								FROM ddon_news
								ORDER BY news_id DESC LIMIT $limit";
			$load_news_params = null;
			$load_news = new Database;
			$load_news->query_data($load_news_sql, $load_news_params, "no", "select_all_data");
			$row = $load_news->fetch_row;

			if($row) {
				foreach($row as $row) {
					$this->news_data[] = array(
						$this->news_id = $row['news_id'],
						$this->news_title = $row['news_title'],
						$this->news_type = $row['news_type'],
						$this->news_poster = $row['news_poster'],
						$this->news_content = $row['news_content'],
						$this->news_date = $row['news_date']
					);
				}
				$this->no_data = "No";
			} else {
				$this->no_date = "Yes";
			}

		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die("Failed To Load News");
		}
		
	}
	
	public function Post_News() {
		
	}
	
	public function Update_News() {
		
	}
	
	public function Delete_News() {
		
	}
	
	
}

?>