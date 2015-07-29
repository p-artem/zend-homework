<?php

class Model_Admin{
    
    protected $_dbTable;
    protected $_row;
    
    public function __construct($id = null)
    {
        $this->_dbTable = new Model_DbTable_Admin();
        if($id)
        {
            $this->_row = $this->_dbTable->find($id)->current();
        }else{
            $this->_row = $this->_dbTable->createRow();
        }
    }
    /**
     * Getters and Setters
     * 
     */
    
    public function __set($name, $value) {
        if(isset($this->_row->$name))
            $this->_row->$name = $value;
    }
    
    public function __get($name) {
        if(isset($this->_row->$name))
           return $this->_row->$name;
    }
    
    public function fill($data)
    {
        foreach ($data as $key => $value)
        {
            if(isset($this->_row->$key))
            {
                $this->_row->$key = $value;
            }
        }
    }
    
    public function save()
    {
        $this->_row->save();
    }
    
    public function updatePage($data)
    {
        $id = $data['id'];
        $res = $this->_dbTable->update($data, 'id='.$id );
        return $res;
    }
    
    public function getAllPage()
    {    
        return $this->_dbTable->fetchAll();
    }
    
    public function deletePage() 
    {
        $row = $this->_row->delete();
        return  $row;
    }
    
    public function populateForm()
    {
        return $this->_row->toArray();
    }

    public function getPageItem($id)
    {
       $row = $this->_dbTable->fetchRow('id='.$id); 
       return $row;
    }
    
    public function getSomePage()
    {
        $select = $this->_dbTable->select();
        $select->limit('3');
        return $this->_dbTable->fetchAll($select);
    }
}