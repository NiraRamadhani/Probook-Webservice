package com.probooks.jaxws.beans;

import java.io.Serializable;

public class Transaksi implements Serializable {

  private static final long serialVersionUID = -5577579081118070434L;

  private String nomorPengirim;
  private String nomorPenerima;
  private int jumlah;

  /**
  * @return String return the nomorPengirim
  */
  public String getNomorPengirim() {
    return nomorPengirim;
  }

  /**
  * @param nomorPengirim the nomorPengirim to set
  */
  public void setNomorPengirim(String nomorPengirim) {
    this.nomorPengirim = nomorPengirim;
  }

  /**
  * @return String return the nomorPenerima
  */
  public String getNomorPenerima() {
    return nomorPenerima;
  }

  /**
  * @param nomorPenerima the nomorPenerima to set
  */
  public void setNomorPenerima(String nomorPenerima) {
    this.nomorPenerima = nomorPenerima;
  }

  /**
  * @return int return the jumlah
  */
  public int getJumlah() {
    return jumlah;
  }

  /**
  * @param jumlah the jumlah to set
  */
  public void setJumlah(int jumlah) {
    this.jumlah = jumlah;
  }

  public String toString(){
    return nomorPengirim+"::"+nomorPenerima+"::"+jumlah;
  }
}
