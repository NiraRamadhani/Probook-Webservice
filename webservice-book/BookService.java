package com.probooks.jaxws.service;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import com.probooks.jaxws.beans.Book;
import com.probooks.jaxws.beans.Transaksi;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
	
	@WebMethod
	public boolean pembelian(String idbook, int quantity, String nomorPengirim) throws IOException;

	@WebMethod
	public void tambahpembelian(String idbook, int quantity);

  @WebMethod
	public Book[] searchBook(String term) throws IOException;

	@WebMethod
	public Book getDetail(String id) throws IOException;

	@WebMethod
	public String getRecommendation(String[] kategori) throws IOException;

}
