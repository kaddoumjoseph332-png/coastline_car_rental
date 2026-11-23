<?php
// Finds one staff account by its username.
function find_admin_by_username($username) {
    global $db;
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin;
}

// Lists every branch for staff.
function find_all_branches() {
    global $db;
    $sql = "SELECT * FROM branches ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// Finds one branch by its id.
function find_branch_by_id($id) {
    global $db;
    $sql = "SELECT * FROM branches WHERE id=" . (int)$id;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $branch = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $branch;
}

// Checks branch form values and returns validation messages.
function validate_branch($branch) {
    $errors = [];
    if (is_blank($branch['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($branch['menu_name'], ['min' => 2, 'max' => 100])) {
        $errors[] = "Name must be between 2 and 100 characters.";      
    }
    if (is_blank($branch['city'])) {
        $errors[] = "City cannot be blank.";
    } elseif (!has_length($branch['city'], ['max' => 50])) {
        $errors[] = "City must be 50 characters or less.";
    }
    if (is_blank($branch['phone'])) {
        $errors[] = "Phone cannot be blank.";
    } elseif (!has_length($branch['phone'], ['max' => 30])) {
        $errors[] = "Phone must be 30 characters or less.";
    }
    if (!ctype_digit($branch['position']) || (int)$branch['position'] > 2147483647) {
        $errors[] = "Position must be a whole number from 0 to 2147483647.";
    }
    if ($branch['visible'] !== '0' && $branch['visible'] !== '1') {
        $errors[] = "Visible must be 0 or 1.";
    }
    return $errors;
}

// Creates a validated branch.
function insert_branch($branch) {
    global $db;
    $errors = validate_branch($branch);
    if (!empty($errors)) {
        return $errors;
    }
    $sql = "INSERT INTO branches (menu_name, position, visible, city, phone) VALUES (";
    $sql .= "'" . db_escape($db, $branch['menu_name']) . "',";
    $sql .= (int)$branch['position'] . ", ";
    $sql .= (int)$branch['visible'] .", ";
    $sql .= "'" . db_escape($db, $branch['city']) . "',";
    $sql .= "'" . db_escape($db, $branch['phone']) . "')";
    $result = mysqli_query($db, $sql);
    return $result ? true : ["Could not save the record. Please try again."];
}

// Saves a validated branch.
function update_branch($branch) {
    global $db;
    $errors = validate_branch($branch);
    if (!empty($errors)) {
        return $errors;
    }
    $sql = "UPDATE branches SET ";
    $sql .= "menu_name='" . db_escape($db, $branch['menu_name']) . "', ";
    $sql .= "position=" . (int)$branch['position'] . ", ";
    $sql .= "visible=" . (int)$branch['visible'] . ", ";
    $sql .= "city='" . db_escape($db, $branch['city']) . "', ";
    $sql .= "phone='" . db_escape($db, $branch['phone']) . "' ";
    $sql .= "WHERE id=" . (int)$branch['id'] . " LIMIT 1";
    $result = mysqli_query($db, $sql);
    return $result ? true : ["Could not save the record. Please try again."];
}

// Deletes a branch when the database allows it.
function delete_branch($id) {
    global $db;
    $sql = "DELETE FROM branches WHERE id=" . (int)$id . " LIMIT 1";
    return mysqli_query($db, $sql);
}

// Lists every car for staff.
function find_all_cars() {
  global $db;
  $sql = "SELECT * FROM cars ORDER BY branch_id ASC, position ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

// Returns one car by id, or null
function find_car_by_id($id) {
  global $db;
  $sql = "SELECT * FROM cars WHERE id=" . (int)$id;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $car = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $car;
}

// Checks car form data and returns a list of errors
function validate_car($car) {
  $errors = [];
  if (!ctype_digit($car['branch_id']) || !find_branch_by_id($car['branch_id'])) {
    $errors[] = "Please choose a valid branch.";
  }
  if (is_blank($car['menu_name'])) {
    $errors[] = "Name cannot be blank.";
  } elseif (!has_length($car['menu_name'], ['min' => 2, 'max' => 100])) {
    $errors[] = "Name must be between 2 and 100 characters.";
  }
  if (is_blank($car['brand'])) {
    $errors[] = "Brand cannot be blank.";
  } elseif (!has_length($car['brand'], ['max' => 50])) {
    $errors[] = "Brand must be 50 characters or less.";
  }
  if (!ctype_digit($car['year']) || $car['year'] < 1990 || $car['year'] > 2100) {
    $errors[] = "Year must be a number between 1990 and 2100.";
  }
  if (!preg_match('/^\d{1,6}(\.\d{1,2})?$/D', $car['price_per_day'])) {
    $errors[] = "Enter a daily price from 0 to 999999.99 with up to two decimal places.";
  }
  if (!ctype_digit($car['position']) || (int)$car['position'] > 2147483647) {
    $errors[] = "Position must be a whole number from 0 to 2147483647.";
  }
  if ($car['visible'] !== '0' && $car['visible'] !== '1') {
    $errors[] = "Visible must be 0 or 1.";
  }
  if (is_blank($car['content'])) {
    $errors[] = "Description cannot be blank.";
  } elseif (!has_length($car['content'], ['max' => 1000])) {
    $errors[] = "Content must be 1000 characters or less.";
  }
  return $errors;
}

// Inserts a car. Returns true, or a list of errors
function insert_car($car) {
  global $db;
  $errors = validate_car($car);
  if (!empty($errors)) { return $errors; }
  $sql = "INSERT INTO cars (branch_id, menu_name, position, visible, content, brand, year, price_per_day) VALUES (";
  $sql .= (int)$car['branch_id'] . ", ";
  $sql .= "'" . db_escape($db, $car['menu_name']) . "', ";
  $sql .= (int)$car['position'] . ", ";
  $sql .= (int)$car['visible'] . ", ";
  $sql .= "'" . db_escape($db, $car['content']) . "', ";
  $sql .= "'" . db_escape($db, $car['brand']) . "', ";
  $sql .= (int)$car['year'] . ", ";
  $sql .= "'" . db_escape($db, $car['price_per_day']) . "')";
  $result = mysqli_query($db, $sql);
  return $result ? true : ["Could not save the record. Please try again."];
}

// Updates a car. Returns true, or a list of errors
function update_car($car) {
  global $db;
  $errors = validate_car($car);
  if (!empty($errors)) { return $errors; }
  $sql = "UPDATE cars SET ";
  $sql .= "branch_id=" . (int)$car['branch_id'] . ", ";
  $sql .= "menu_name='" . db_escape($db, $car['menu_name']) . "', ";
  $sql .= "position=" . (int)$car['position'] . ", ";
  $sql .= "visible=" . (int)$car['visible'] . ", ";
  $sql .= "content='" . db_escape($db, $car['content']) . "', ";
  $sql .= "brand='" . db_escape($db, $car['brand']) . "', ";
  $sql .= "year=" . (int)$car['year'] . ", ";
  $sql .= "price_per_day='" . db_escape($db, $car['price_per_day']) . "' ";
  $sql .= "WHERE id=" . (int)$car['id'] . " LIMIT 1";
  $result = mysqli_query($db, $sql);
  return $result ? true : ["Could not save the record. Please try again."];
}

// Deletes one car by its id.
function delete_car($id) {
  global $db;
  $sql = "DELETE FROM cars WHERE id=" . (int)$id . " LIMIT 1";
  return mysqli_query($db, $sql);
}

// Lists public branches in display order.
function find_visible_branches() {
    global $db;
    $sql = "SELECT * FROM branches WHERE visible = 1 ORDER BY position ASC, id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// Lists public cars assigned to one branch.
function find_visible_cars_by_branch_id($branch_id) {
    global $db;
    $sql = "SELECT * FROM cars WHERE branch_id = " . (int)$branch_id . " AND visible=1 ORDER BY position ASC, id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// Counts all cars assigned to a branch, including hidden cars.
function count_cars_in_branch($id) {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM cars WHERE branch_id=" . (int)$id;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return (int)$row['total'];
}
