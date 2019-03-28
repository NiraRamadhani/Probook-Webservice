package com.probooks.jaxws.beans;

import java.io.Serializable;
import java.util.Arrays;

public class Book implements Serializable {

  private static final long serialVersionUID = -5577579081118070434L;

  private String id;
  private String judul;
  private String[] penulis;
  private String gambar;
  private String sinopsis;
  private float rating;
  private int votescount;
  private String[] kategori;
  private float harga;

  /**
  * @return int return the id
  */
  public String getId() {
    return id;
  }

  /**
  * @param id the id to set
  */
  public void setId(String id) {
    this.id = id;
  }

  /**
  * @return String return the judul
  */
  public String getJudul() {
    return judul;
  }

  /**
  * @param judul the judul to set
  */
  public void setJudul(String judul) {
    this.judul = judul;
  }

  /**
  * @return String return the penulis
  */
  public String[] getPenulis() {
    return penulis;
  }

  /**
  * @param penulis the penulis to set
  */
  public void setPenulis(String[] penulis) {
    this.penulis = Arrays.copyOf(penulis, penulis.length);
  }

  /**
  * @return String return the gambar
  */
  public String getGambar() {
    return gambar;
  }

  /**
  * @param gambar the gambar to set
  */
  public void setGambar(String gambar) {
    this.gambar = gambar;
  }

  /**
  * @return String return the sinopsis
  */
  public String getSinopsis() {
    return sinopsis;
  }

  /**
  * @param sinopsis the sinopsis to set
  */
  public void setSinopsis(String sinopsis) {
    this.sinopsis = sinopsis;
  }

  /**
  * @return float return the rating
  */
  public float getRating() {
    return rating;
  }

  /**
  * @param rating the rating to set
  */
  public void setRating(float rating) {
    this.rating = rating;
  }

  public String toString(){
    return id+"::"+judul+"::"+penulis+"::"+gambar+"::"+sinopsis+"::"+rating;
  }
  
  public void setVotesCount(int votescount) {
    this.votescount = votescount;
  } 

  public int getVotesCount() {
    return votescount;    
  }

  public void setKategori(String[] kategori) {
    this.kategori = kategori;
  }

  public String[] getKategori() {
    return kategori;
  }

  public void setHarga(float harga){
    this.harga = harga;
  }

  public float getHarga(){
    return harga;
  }


}