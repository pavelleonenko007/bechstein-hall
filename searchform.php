<form action="<?php echo home_url('/') ?>" class="search-filter">
  <input type="search" value="<?php echo get_search_query() ?>" class="search-line-input w-input" maxlength="256" name="s" placeholder="search by keyword…" id="s" required="" />
  <input type="submit" value="Search" class="search-line-btn w-button" />
</form>