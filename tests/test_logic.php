<?php
// Mock PDO and Statement classes for testing
class MockPDO {
    public $rules = [];
    public $penyakit = [
        'P03' => ['id' => 'P03', 'nama' => 'Coccidiosis']
    ];

    public function query($sql) {
        return new MockStatement($this->rules);
    }

    public function prepare($sql) {
        return new MockStatement($this->penyakit);
    }
}

class MockStatement {
    private $data;
    public function __construct($data) {
        $this->data = $data;
    }
    public function fetchAll() {
        return $this->data;
    }
    public function execute($params) {
        $this->current = $this->data[$params[0]] ?? null;
    }
    public function fetch() {
        return $this->current ?? reset($this->data);
    }
}

// Minimal reproduction of get_diagnosa logic for testing
function test_forward_chaining($rules_raw, $selected_gejala) {
    $rules = [];
    foreach ($rules_raw as $row) {
        $rules[$row['id_aturan']]['id_penyakit'] = $row['id_penyakit'];
        $rules[$row['id_aturan']]['gejala'][] = $row['id_gejala'];
    }

    $best_match = null;
    $max_match_count = 0;

    foreach ($rules as $rule_id => $rule_data) {
        $rule_gejala = $rule_data['gejala'];
        $intersection = array_intersect($rule_gejala, $selected_gejala);
        $match_count = count($intersection);
        $total_rule_gejala = count($rule_gejala);

        if ($match_count === $total_rule_gejala) {
            if ($match_count > $max_match_count) {
                $max_match_count = $match_count;
                $best_match = $rule_data['id_penyakit'];
            }
        }
    }
    return $best_match;
}

// Define test data based on schema.sql
$rules_raw = [
    ['id_aturan' => 'R07', 'id_penyakit' => 'P03', 'id_gejala' => 'G03'],
    ['id_aturan' => 'R07', 'id_penyakit' => 'P03', 'id_gejala' => 'G04'],
    ['id_aturan' => 'R07', 'id_penyakit' => 'P03', 'id_gejala' => 'G05'],
];

// Test Case 1: Match P03
$selected_1 = ['G03', 'G04', 'G05', 'G01']; // G01 is extra
$result_1 = test_forward_chaining($rules_raw, $selected_1);
echo "Test 1 (Expected P03): " . ($result_1 === 'P03' ? "PASS" : "FAIL ($result_1)") . "\n";

// Test Case 2: No match (missing G05)
$selected_2 = ['G03', 'G04'];
$result_2 = test_forward_chaining($rules_raw, $selected_2);
echo "Test 2 (Expected null): " . ($result_2 === null ? "PASS" : "FAIL ($result_2)") . "\n";

// Test Case 3: P01 match
$rules_p01 = [
    ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G14'],
    ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G15'],
    ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G16'],
];
$selected_3 = ['G14', 'G15', 'G16'];
$result_3 = test_forward_chaining($rules_p01, $selected_3);
echo "Test 3 (Expected P01): " . ($result_3 === 'P01' ? "PASS" : "FAIL ($result_3)") . "\n";
?>
