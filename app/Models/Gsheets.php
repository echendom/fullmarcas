<?php

namespace App\Models;

require '../../../vendor/autoload.php';
// use Google_Client;
// use Google_Service_Sheets;
// use Google_Service_Sheets_ValueRange;

// /**
//  * Returns an authorized API client.
//  *
//  * @return Google_Client the authorized client object
//  */
class Gsheets
{
    public function getClient($data, $range, $flag = 0)
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets GTP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('../../../credentials.json');

        // Get the API client and construct the service object.
        // $client = $this->getClient($id, $data);
        $service = new \Google_Service_Sheets($client);

        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        // $spreadsheetId = get_field('document_id', 'option');
        $spreadsheetId = '1yV5-votSKUUBU5aFslSQiy7cbUBhZweDcoHorT0W1Uw';
        $valueInputOption = 'USER_ENTERED';
        $i = 0;
        foreach ($data as $d) {
            $values[0][$i] = $d;
            ++$i;
        }
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values,
        ]);
        $params = [
            'valueInputOption' => $valueInputOption,
        ];
        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        // printf('%d cells appended.', $result->getUpdates()->getUpdatedCells());
        // die;
    }
}