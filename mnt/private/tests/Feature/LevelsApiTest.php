<?php

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the table
        $this->pdo->exec(<<<SQL
            CREATE TABLE `to_date` (
                `CLUB_ID` INT NOT NULL,
                `ANNU_YEAR` DATE NOT NULL,
                `CLUB_INSCRIPTIONNB` INT NOT NULL,
                `CLUB_NBDEGREEOBTAINED` INT NOT NULL
            );
        SQL);

        // Insert initial data
        $this->pdo->exec(<<<SQL
            INSERT INTO `to_date` (`CLUB_ID`, `ANNU_YEAR`, `CLUB_INSCRIPTIONNB`, `CLUB_NBDEGREEOBTAINED`) VALUES
            (1, '2024-01-01', 48, 2),
            (1, '2025-01-01', 50, 3),
            (2, '2022-01-01', 45, 5);
        SQL);
    }

    public function testRowCount(): void
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM `to_date`');
        $rowCount = $stmt->fetchColumn();
        $this->assertEquals(3, $rowCount, 'The number of rows should be 3.');
    }

    public function testInsertData(): void
    {
        $this->pdo->exec("INSERT INTO `to_date` (`CLUB_ID`, `ANNU_YEAR`, `CLUB_INSCRIPTIONNB`, `CLUB_NBDEGREEOBTAINED`) VALUES (3, '2023-01-01', 30, 1);");

        $stmt = $this->pdo->query('SELECT COUNT(*) FROM `to_date`');
        $rowCount = $stmt->fetchColumn();
        $this->assertEquals(4, $rowCount, 'After inserting, the number of rows should be 4.');
    }

    public function testRetrieveData(): void
    {
        $stmt = $this->pdo->query('SELECT * FROM `to_date` WHERE `CLUB_ID` = 1');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(2, $result, 'There should be 2 rows for CLUB_ID 1.');
        $this->assertEquals('2024-01-01', $result[0]['ANNU_YEAR'], 'The first year for CLUB_ID 1 should be 2024-01-01.');
    }

    public function testUpdateData(): void
    {
        $this->pdo->exec("UPDATE `to_date` SET `CLUB_INSCRIPTIONNB` = 60 WHERE `CLUB_ID` = 1 AND `ANNU_YEAR` = '2024-01-01';");

        $stmt = $this->pdo->query('SELECT `CLUB_INSCRIPTIONNB` FROM `to_date` WHERE `CLUB_ID` = 1 AND `ANNU_YEAR` = "2024-01-01"');
        $result = $stmt->fetchColumn();

        $this->assertEquals(60, $result, 'The CLUB_INSCRIPTIONNB for CLUB_ID 1 in 2024 should be updated to 60.');
    }

    public function testDeleteData(): void
    {
        $this->pdo->exec("DELETE FROM `to_date` WHERE `CLUB_ID` = 2;");

        $stmt = $this->pdo->query('SELECT COUNT(*) FROM `to_date`');
        $rowCount = $stmt->fetchColumn();

        $this->assertEquals(2, $rowCount, 'After deletion, the number of rows should be 2.');
    }




    public function testDeleteEntries()
    {
        for ($i = 1; $i <= 1000; $i++) {
            $this->pdo->exec("DELETE FROM to_date WHERE CLUB_ID = $i");

            $stmt = $this->pdo->query("SELECT * FROM to_date WHERE CLUB_ID = $i");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->assertFalse($result);
        }
    }


    public function testEdgeCaseDates()
    {
        $this->pdo->exec("INSERT INTO to_date (CLUB_ID, ANNU_YEAR, CLUB_INSCRIPTIONNB, CLUB_NBDEGREEOBTAINED) VALUES
            (2000, '1900-01-01', 10, 1),
            (2001, '2100-01-01', 20, 2)");

        $stmt = $this->pdo->query("SELECT * FROM to_date WHERE CLUB_ID = 2000");
        $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('1900-01-01', $result1['ANNU_YEAR']);

        $stmt = $this->pdo->query("SELECT * FROM to_date WHERE CLUB_ID = 2001");
        $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('2100-01-01', $result2['ANNU_YEAR']);
    }

}

?>
