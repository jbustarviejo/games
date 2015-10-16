library(scatterplot3d)

data <- matrix(c(
#Fijo
0,5/7,0,
0,5/7,2/3,
0,2/7,1/3,
#Móvil
0,6/7,2/3,
0,7/7,2/3,
0,4/7,3/3,
#internet y fijo
0.25,4/7,1/3,
0.25,3/7,2/3,
0.25,3/7,2/3,
#Fusión
1,4/7,2/3,
1,2/7,2/3,
1,2/7,3/3
),ncol=3,byrow=TRUE)
colnames(data) <- c("Combinatoria", "RI","Azar")
data <- data.frame(data)

data$pcolor[1] <- "red"
data[1,]$pcolor<-"blue"
data[2,]$pcolor<-"orange"
data[4,]$pcolor<-"blue"
data[5,]$pcolor<-"orange"
data[7,]$pcolor<-"blue"
data[8,]$pcolor<-"orange"
data[10,]$pcolor<-"blue"
data[11,]$pcolor<-"orange"

data
with(data, {
   scatterplot3d(Azar,   # x axis
                 RI,     # y axis
                 Combinatoria,    # z axis
                 color=pcolor,
                 main="Representacion 3-D del riesgo")
})
