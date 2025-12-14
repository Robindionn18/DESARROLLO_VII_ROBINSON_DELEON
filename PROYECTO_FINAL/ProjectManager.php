<?php

require_once __DIR__ . '/Database.php';

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
    public function createUser($first_name, $last_name, $email, $password) {
        $role = 1; //usuario
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (password, email, first_name, last_name, role) VALUES (?,?,?,?,?)");
        return $stmt->execute([$hashedPassword, $email, $first_name, $last_name, $role]);
    }

    //(Gestion de Usuarios)Iniciar sesión
    public function loginUser($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
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
    public function loginStaff($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM username WHERE email = ? AND");
        $stmt->execute([$email]);
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

    //(Catalogo de Libros)Añadir libro al catalogo()
    public function addBook($title, $author, $category, $release_date, $aviable) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, category, release_date, aviable) VALUES (?,?,?,?,?)");
        return $stmt->execute([$title, $author, $category, $release_date, $aviable]);
    }

    //(Catalogo de Libros) Ordenar libros (Title, Release, Category, Available, ID)
    public function sortBooksBy($field) {
    $allowedFields = ['id', 'title', 'release_date', 'category', 'aviable'];
    if (!in_array($field, $allowedFields)) {
        $field = 'id';
    }
    $stmt = $this->db->query("SELECT * FROM books ORDER BY $field ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    //(Catalogo de Libros)Buscar libro en el catalogo
    public function searchBooks($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ?");
        $likeKeyword = '%' . $keyword . '%';
        $stmt->execute([$likeKeyword, $likeKeyword, $likeKeyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //(Prestamos y reservas)Reservar libro
    public function reserveBook($userId, $bookId) {

    // Verificar disponibilidad
    $stmt = $this->db->prepare("SELECT aviable FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book || $book['aviable'] == 0) {
        return false;
    }

    // Crear reserva
    $stmt = $this->db->prepare("INSERT INTO reservations (user_id, book_id, reservation_date, status) VALUES (?, ?, NOW(), 'Pendiente')");
    return $stmt->execute([$userId, $bookId]);
    }

    //(Prestamos y reservas)Ver reservas de usuario
    public function getUserReservations($userId) {
    $stmt = $this->db->prepare(
        "SELECT r.*, b.title 
         FROM reservations r
         JOIN books b ON b.id = r.book_id
         WHERE r.user_id = ? AND r.status = 'Pendiente'"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //(Prestamos y reservas)Cancelar reserva
    public function cancelReservation($reservationId) {
    $stmt = $this->db->prepare("SELECT book_id FROM reservations WHERE id = ?");
    $stmt->execute([$reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reservation) return false;
    $stmt = $this->db->prepare(
        "UPDATE reservations SET status = 'cancelled' WHERE id = ?");
    return $stmt->execute([$reservationId]);
    }


    //(Prestamos y reservas)Prestamo de libro (Administración)
    public function getAllReservations() {
    $stmt = $this->db->query(
        "SELECT r.*, u.first_name, b.title
         FROM reservations r
         JOIN users u ON u.id = r.user_id
         JOIN books b ON b.id = r.book_id
         WHERE r.status = 'Pendiente'"
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    //(Prestamos y reservas)Aprobar reserva
    public function approveReservation($reservationId, $days = 7) {

    // Obtener datos de la reserva
    $stmt = $this->db->prepare(
        "SELECT * FROM reservations WHERE id = ? AND status = 'Pendiente'"
    );
    $stmt->execute([$reservationId]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$res) return false;

    // Crear préstamo
    $stmt = $this->db->prepare(
        "INSERT INTO loans (user_id, book_id, lend_date, due_date) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL ? DAY))");
    $stmt->execute([$res['user_id'], $res['book_id'], $days]);

    // Cambiar estado reserva
    $stmt = $this->db->prepare(
        "UPDATE reservations SET status = 'Aprovado' WHERE id = ?"
    );
    $stmt->execute([$reservationId]);

    // Cambiar disponibilidad libro
    $stmt = $this->db->prepare(
        "UPDATE books SET aviable = 0 WHERE id = ?"
    );
    $stmt->execute([$res['book_id']]);

    return true;
}


    //(Fechas y Devoluciones)Tiempo de devolucion
    public function getLoanDueDate($loanId) {
    $stmt = $this->db->prepare(
        "SELECT due_date FROM loans WHERE id = ?"
    );
    $stmt->execute([$loanId]);
    return $stmt->fetchColumn();
    }

    //(Fechas y Devoluciones)Tiempo restante del cliente
    public function getActiveLoansByUser($userId) {
    $stmt = $this->db->prepare(
        "SELECT l.*, b.title 
         FROM loans l
         JOIN books b ON b.id = l.book_id
         WHERE l.user_id = ? AND l.return_date IS NULL"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    //(Fechas y Devoluciones)Devolver Libro
    public function returnBook($loanId) {
    // Marcar devolución
    $stmt = $this->db->prepare("UPDATE loans SET return_date = CURDATE() WHERE id = ?");
    $stmt->execute([$loanId]);

    // Obtener libro
    $stmt = $this->db->prepare("SELECT book_id FROM loans WHERE id = ?");
    $stmt->execute([$loanId]);
    $bookId = $stmt->fetchColumn();
    // Volver a marcar libro como disponible
    $stmt = $this->db->prepare("UPDATE books SET aviable = 1 WHERE id = ?");
    return $stmt->execute([$bookId]);
}

    //(Fechas y Devoluciones)Estado de Devolucion (Mejorado)
    public function getReturnStatus($loanId) {
    $stmt = $this->db->prepare(
        "SELECT due_date, return_date FROM loans WHERE id = ?"
    );
    $stmt->execute([$loanId]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$loan) return "No existe";

    if ($loan['return_date'] === null) {
        return "No devuelto";
    }

    if (strtotime($loan['return_date']) > strtotime($loan['due_date'])) {
        return "Devuelto con retraso";
    }

    return "Devuelto a tiempo";
}


    //(Multas y Sanciones)Comprobar estado de devolucion
    public function checkLateLoan($loanId) {
    $stmt = $this->db->prepare(
        "SELECT due_date, return_date, user_id FROM loans WHERE id = ?");
    $stmt->execute([$loanId]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$loan) return false;
    $due = strtotime($loan['due_date'] . ' +1 hour');
    $returned = $loan['return_date'] ? strtotime($loan['return_date']): time();

    if ($returned > $due) {
        return $loan;
    }

    return false;
}
    //(Multas y Sanciones)Calcular monto de la multa
    public function calculateFineAmount($loan) {

    $due = strtotime($loan['due_date']);
    $end = $loan['return_date']
        ? strtotime($loan['return_date'])
        : time();

    $daysLate = ceil(($end - $due) / 86400);

    if ($daysLate < 1) $daysLate = 1;

    return $daysLate * 2; // $2 por día
}




    //(Multas y Sanciones)Multar usuario
    public function imposeFine($loanId) {

    // Verificar si ya existe multa
    $stmt = $this->db->prepare(
        "SELECT id FROM fines WHERE loan_id = ?");
    $stmt->execute([$loanId]);
    if ($stmt->fetch()) return false;

    $loan = $this->checkLateLoan($loanId);
    if (!$loan) return false;

    $amount = $this->calculateFineAmount($loan);

    $stmt = $this->db->prepare(
        "INSERT INTO fines (user_id, loan_id, fine_amount, reason, is_paid) VALUES (?, ?, ?, ?, 0)");

    return $stmt->execute([
        $loan['user_id'], $loanId, $amount, 'Entrega fuera de tiempo']);
}

    //(Multas y Sanciones)Obtener multas de usuario
    public function getUserFines($userId) {
    $stmt = $this->db->prepare("SELECT * FROM fines WHERE user_id = ? AND is_paid = 0");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //(Multas y Sanciones)Duracion de la multa
    public function getFineDuration($fineId) {
        $stmt = $this->db->prepare("SELECT imposed_date, due_date FROM fines WHERE id = ?");
        $stmt->execute([$fineId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //(Multas y Sanciones)Total de la Multa
    public function getTotalFines($userId) {
    $stmt = $this->db->prepare(
        "SELECT SUM(fine_amount) FROM fines
         WHERE user_id = ? AND is_paid = 0"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() ?? 0;
    }


    //(Multas y Sanciones)Pagar Multa
    public function payFine($fineId) {
    $stmt = $this->db->prepare(
        "UPDATE fines SET is_paid = 1 WHERE id = ?"
    );
    return $stmt->execute([$fineId]);
    }

    //(Multas y Sanciones)Ver todas las multas (Admin)
    public function getAllFines() {
    $stmt = $this->db->query(
        "SELECT f.*, u.first_name, u.last_name, b.title
         FROM fines f
         JOIN users u ON u.id = f.user_id
         LEFT JOIN loans l ON l.id = f.loan_id
         LEFT JOIN books b ON b.id = l.book_id
         ORDER BY f.is_paid ASC, f.imposed_date DESC"
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}