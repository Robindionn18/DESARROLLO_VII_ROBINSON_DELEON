<?php
class ProjectManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las tareas
    public function getAllTasks() {
        $stmt = $this->db->query("SELECT * FROM tasks ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva tarea
    public function createTask($title, $description) {
        $stmt = $this->db->prepare("INSERT INTO tasks (title,description) VALUES (?,?)");
        return $stmt->execute([$title, $description]);

    }

    // Método para crear una nueva tarea
    public function createProject($project) {
        $stmt = $this->db->prepare("INSERT INTO projects (name, description, status) VALUES (?,?,?)");
        $payload = [$project->name, $project->description, $project->status];
        return $stmt->execute($payload);

    }

    // Método para cambiar el estado de una tarea (completada/no completada)
    public function toggleTask($id) {
        $stmt = $this->db->prepare("UPDATE tasks SET is_completed = NOT is_completed WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Método para eliminar una tarea
    public function deleteTask($id) {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }

    //(Gestion de Usuarios)Crear un nuevo usuario
    public function createUser($username, $password, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (?,?,?)");
        return $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), $role]);
    }

    //(Gestion de Usuarios)Iniciar sesión
    public function loginUser($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    //(Gestion de Usuarios)Cerrar sesión
    public function logoutUser() {
        session_start();
        session_unset();
        session_destroy();
    }

    //(Gestion de Usuarios)Iniciar sesión(Personal)
    public function loginStaff($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE username = ?");
        $stmt->execute([$username]);
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($staff && password_verify($password, $staff['password'])) {
            return $staff;
        } else {
            return false;
        }
    }

    //(Catalogo de Libros)Mostrar catalogo de libros
        public function getAllBooks() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //(Catalogo de Libros)Añadir libro al catalogo
    public function addBook($title, $author, $category, $release_date, $aviable) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, category, release_date, aviable) VALUES (?,?,?,?,?)");
        return $stmt->execute([$title, $author, $category, $release_date, $aviable]);
    }

    //(Catalogo de Libros)Ordenar libros segun titulo
    public function sortBooksByTitle() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY title ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     //(Catalogo de Libros)Ordenar libros segun Fecha de Publicacion
    public function sortBooksByRelease() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY release_date");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     //(Catalogo de Libros)Ordenar libros segun categoria    
    public function sortBooksByCategory() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     //(Catalogo de Libros)Ordenar libros segun disponibilidad
    public function sortBooksByAvilable() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY aviable ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //(Catalogo de Libros)Buscar libro en el catalogo
    public function searchBooks($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ?");
        $likeKeyword = '%' . $keyword . '%';
        $stmt->execute([$likeKeyword, $likeKeyword, $likeKeyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //(Catalogo de Libros)Mostrar datos del libro seleccionado
    public function getBookById($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //(Prestamos y reservas)Reservar libro
    public function reserveBook($userId, $bookId, $reservationDate) {
        $stmt = $this->db->prepare("INSERT INTO reservations (user_id, book_id, reservation_date) VALUES (?,?,?)");
        return $stmt->execute([$userId, $bookId, $reservationDate]);
    }

    //(Prestamos y reservas)Cancelar reserva
    public function cancelReservation($reservationId) {
        $stmt = $this->db->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$reservationId]);
    }

    //(Prestamos y reservas)Prestamo de libro
    public function lendBook($userId, $bookId, $lendDate, $dueDate) {
        $stmt = $this->db->prepare("INSERT INTO loans (user_id, book_id, lend_date, due_date) VALUES (?,?,?,?)");
        return $stmt->execute([$userId, $bookId, $lendDate, $dueDate]);
    }

    //(Fechas y Devoluciones)Tiempo de devolucion
    public function getDueDate($loanId) {
        $stmt = $this->db->prepare("SELECT due_date FROM loans WHERE id = ?");
        $stmt->execute([$loanId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['due_date'];
    }

    //(Fechas y Devoluciones)Devolver Libro
    public function returnBook($loanId, $returnDate) {
        $stmt = $this->db->prepare("UPDATE loans SET return_date = ? WHERE id = ?");
        return $stmt->execute([$returnDate, $loanId]);
    }

    //(Fechas y Devoluciones)Estado de Devolucion
    public function checkReturnStatus($loanId) {
        $stmt = $this->db->prepare("SELECT return_date, due_date FROM loans WHERE id = ?");
        $stmt->execute([$loanId]);
        $loan = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($loan['return_date'] === null) {
            return 'Not Returned';
        } elseif (strtotime($loan['return_date']) > strtotime($loan['due_date'])) {
            return 'Late';
        } else {
            return 'On Time';
        }
    }

    //(Multas y Sanciones)Comprobar estado de devolucion
    public function checkFineStatus($userId) {
        $stmt = $this->db->prepare("SELECT SUM(fine_amount) AS total_fines FROM fines WHERE user_id = ? AND is_paid = 0");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_fines'] ?? 0;
    }


    //(Multas y Sanciones)Multar usuario
    public function imposeFine($userId, $amount, $reason) {
        $stmt = $this->db->prepare("INSERT INTO fines (user_id, fine_amount, reason, is_paid) VALUES (?,?,?,0)");
        return $stmt->execute([$userId, $amount, $reason]);
    }

    //(Multas y Sanciones)Duracion de la multa
    public function getFineDuration($fineId) {
        $stmt = $this->db->prepare("SELECT imposed_date, due_date FROM fines WHERE id = ?");
        $stmt->execute([$fineId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //(Multas y Sanciones)Total de la Multa
    public function getTotalFines($userId) {
        $stmt = $this->db->prepare("SELECT SUM(fine_amount) AS total_fines FROM fines WHERE user_id = ? AND is_paid = 0");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_fines'] ?? 0;
    }

    //(Multas y Sanciones)Pagar Multa
    public function payFine($fineId) {
        $stmt = $this->db->prepare("UPDATE fines SET is_paid = 1 WHERE id = ?");
        return $stmt->execute([$fineId]);
    }

}