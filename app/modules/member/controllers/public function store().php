public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        if ($this->input->post('new')!=1) {
            $this->form_validation->set_rules('membership_number', 'Member ID', 'trim|required');
            $this->form_validation->set_rules('member_id', 'Member ID', 'trim|required');
        }

        $this->form_validation->set_rules('month_period', 'Month', 'trim|required');
        $this->form_validation->set_rules('recepit_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('finish_date', 'Finish Date', 'trim|required');
        $this->form_validation->set_rules('total_amount', 'Amount', 'trim|required');

        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $recepitNo = $this->receiptModel->receiptNo();

            $rDate = str_replace('/', '-', $this->input->post('recepit_date'));
            $sDate = str_replace('/', '-', $this->input->post('start_date'));
            $fDate = str_replace('/', '-', $this->input->post('finish_date'));
            $data = [
                'member_id' => $this->input->post('member_id'),
                'receipt_member' => $this->input->post('receipt_member'),
                'recepit_number' => $recepitNo,
                'recepit_description' => $this->input->post('recepit_description'),
                'month_period' => $this->input->post('month_period'),
                'recepit_date' => date("Y-m-d", strtotime($rDate)),
                'start_date' => date("Y-m-d", strtotime($sDate)),
                'finish_date' => date("Y-m-d", strtotime($fDate)),
                'total_amount' => $this->input->post('total_amount'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->receiptModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $amountArr = array_filter($this->input->post('amount'));
                if (!empty($amountArr)) {
                    $insDataArr = [];
                    foreach ($amountArr as $key => $amount) {
                        $catData = [
                            'receipt_id' => $insId,
                            'amount' => $amount,
                            'category_id' => $this->input->post('category_id')[$key],
                        ];
                        $insDataArr[] = $this->security->xss_clean($catData);
                    }
                    $this->receiptModel->insertBatch('receipt_data', $insDataArr);

                    $this->session->set_flashdata('flash_msg', $this->alert->success('Receipt Added Successfully.'));
                } else {
                    $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Category Not Found!'));
                }

                redirect($this->path.'/prints/'.$insId.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Adding Failed. '.$insId));

                $this->create();
            }
        }
    }